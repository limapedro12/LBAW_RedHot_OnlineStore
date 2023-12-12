<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Review;
use App\Events\ProductOutOfStock;

use App\Http\Controllers\FileController;

class Product extends Model{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = 'produto';

    protected $fillable = [
        'nome',
        'descricao',
        'precoatual',
        'desconto',
        'stock',
        'id_administrador',
        'product_image',
        'categoria'
    ];

    public static function searchProducts(string $stringToSearch){
        // $stringToSearch = "'".$stringToSearch."'";
        $searchTemperature = 0.1;
        $searchedProducts = Product::whereRaw("tsvectors @@ to_tsquery('portuguese', CAST(? AS VARCHAR)) ".
                                              "OR (LOWER(nome) LIKE CONCAT('%',  LOWER(CAST(? AS VARCHAR)), '%'))", 
                                              [$stringToSearch, $stringToSearch])
                                   ->orderByRaw("ts_rank(tsvectors, to_tsquery('portuguese', ?)) DESC", [$stringToSearch])
                                   ->get();
        return $searchedProducts;
        // whereRaw("ts_rank(tsvectors, to_tsquery('portuguese', ?)) > ?", [$stringToSearch, $searchTemperature])
    }   

    public static function filterFunctionFactory($filter){
        return function($product) use ($filter){
            $price = $filter->{'price'};
            $categories = $filter->{'categories'};
            $discount = $filter->{'discount'};
            $rating = $filter->{'rating'};

            if($price->{'min'} != null)
                if($product->precoatual*(1 - $product->desconto) < $price->{'min'})
                    return false;

            if($price->{'max'} != null)
                if($product->precoatual*(1 - $product->desconto) > $price->{'max'})
                    return false;

            if($categories != [])
                if(!in_array($product->categoria, $categories))
                    return false;

            if($discount != []){
                $inteval_function = fn($interval) =>
                    ($product->desconto >= $interval->{'min'} && $product->desconto <= $interval->{'max'});
                if(!in_array(true, array_map($inteval_function, $discount)))
                    return false;
            } 

            if($rating != []){
                if($product->getNumberOfReviews() == 0)
                    return false;
                $averageRating = $product->getAverageRating();
                $inteval_function = fn($interval) =>
                    ($averageRating >= $interval->{'min'} && $averageRating <= $interval->{'max'});
                if(!in_array(true, array_map($inteval_function, $rating)))
                    return false;
            }

            return true;
        };
    }

    public static function collectionToArray($collection){
        $array = array();
        foreach($collection as $element){
            array_push($array, $element);
        }
        return $array;
    }

    public static function order(string $orderBy, $products){
        // nameAsc, nameDesc, priceAsc, priceDesc, ratingAsc, ratingDesc, discountAsc, discountDesc
        if($orderBy == 'priceDesc')
            usort($products, function($a, $b){
                return ($b->precoatual*(1 - $b->desconto)) > ($a->precoatual*(1 - $a->desconto));
            });
        else if($orderBy == 'priceAsc')
            usort($products, function($a, $b){
                return ($a->precoatual*(1 - $a->desconto)) > ($b->precoatual*(1 - $b->desconto));
            });
        else if($orderBy == 'nameDesc')
            usort($products, function($a, $b){
                return $b->nome > $a->nome;
            });
        else if($orderBy == 'nameAsc')
            usort($products, function($a, $b){
                return $a->nome > $b->nome;
            });
        else if($orderBy == 'ratingDesc')
            usort($products, function($a, $b){
                return $b->getAverageRating() > $a->getAverageRating();
            });
        else if($orderBy == 'ratingAsc')
            usort($products, function($a, $b){
                return $a->getAverageRating() > $b->getAverageRating();
            });
        else if($orderBy == 'discountDesc')
            usort($products, function($a, $b){
                return $b->desconto > $a->desconto;
            });
        else if($orderBy == 'discountAsc')
            usort($products, function($a, $b){
                return $a->desconto > $b->desconto;
            });
        return $products;
    }

    public static function filterProducts($filter){

        $filteredProducts = array_filter(Product::collectionToArray(Product::all()), Product::filterFunctionFactory($filter));
        $orderedProducts = Product::order($filter->{'orderBy'}, $filteredProducts);
        return $orderedProducts;
    }

    public static function searchAndFilterProducts(string $stringToSearch, $filter){
        $searchedProducts = Product::searchProducts($stringToSearch);
        $filteredProducts = array_filter(Product::collectionToArray($searchedProducts), Product::filterFunctionFactory($filter));
        $orderedProducts = Product::order($filter->{'orderBy'}, $filteredProducts);
        return $orderedProducts;
    }

    public function decrementStock(int $quantity){
        $this->stock -= $quantity;
        $this->save();
        if($this->stock <= 0){
            event(new ProductOutOfStock($this->id_administrador, $this->id, $this->nome));
        }
    }

    public function incrementStock(int $quantity){
        $this->stock += $quantity;
        $this->save();
    }

    public static function getMostExpensiveProductPrice(){
        return round(Product::orderBy('precoatual', 'desc')->first()->precoatual + 1, 0);
    }

    public static function getAllCategories(){
        $categories = DB::table('produto')->select('categoria')->distinct()->get();
        $categoriesArray = array();
        foreach($categories as $category){
            if($category->categoria != null){
                array_push($categoriesArray, $category->categoria);
            }
        }
        return $categoriesArray;
    }
    public function getProductImage() {
        return FileController::get('product', $this->id);
    }

    public function getAverageRating(){
        $reviews = Review::where('id_produto', '=', $this->id)->get();
        if(count($reviews) == 0)
            return 5;
        $sum = 0;
        foreach($reviews as $review){
            $sum += $review->avaliacao;
        }
        if(count($reviews) == 0)
            return 0;
        return $sum/count($reviews);
    }

    public function getNumberOfReviews(){
        return count(Review::where('id_produto', '=', $this->id)->get());
    }
}
