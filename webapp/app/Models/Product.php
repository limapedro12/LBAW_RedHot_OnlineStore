<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;
use App\Events\ProductOutOfStock;

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
        $searchTemperature = 0.1;
        $searchedProducts = DB::table('produto')
                            ->whereRaw("ts_rank(tsvectors, plainto_tsquery('portuguese', ?)) > ?", [$stringToSearch, $searchTemperature])
                            ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('portuguese', ?)) DESC", [$stringToSearch])
                            ->get();

        return $searchedProducts;
    }

    // This function will take a raw string filter and return a tring to display in the html
    public static function filterToDisplay(string $filter){
        $splitedFilter = explode(";", $filter);
        $filterToDisplay = "";
        foreach($splitedFilter as $partOfFilter){
            $splitedPartOfFilter = explode(":", $partOfFilter);
            if($splitedPartOfFilter[0] == "preco"){
                if($splitedPartOfFilter[1] == "min"){
                    $filterToDisplay = $filterToDisplay . "Preço mínimo: " . $splitedPartOfFilter[2] . "€; ";
                }
                else if($splitedPartOfFilter[1] == "max"){
                    $filterToDisplay = $filterToDisplay . "Preço máximo: " . $splitedPartOfFilter[2] . "€; ";
                }
            }
            else if($splitedPartOfFilter[0] == "desconto"){
                if(sizeof($splitedPartOfFilter) == 1){
                    $filterToDisplay = $filterToDisplay . "Com desconto; ";
                }
                else if($splitedPartOfFilter[1] == "min"){
                    $filterToDisplay = $filterToDisplay . "Desconto mínimo: " . $splitedPartOfFilter[2] . "%; ";
                }
                else if($splitedPartOfFilter[1] == "max"){
                    $filterToDisplay = $filterToDisplay . "Desconto máximo: " . $splitedPartOfFilter[2] . "%; ";
                }
            }
            else if($splitedPartOfFilter[0] == "stock"){
                if($splitedPartOfFilter[1] == "min"){
                    $filterToDisplay = $filterToDisplay . "Stock mínimo: " . $splitedPartOfFilter[2] . "; ";
                }
                else if($splitedPartOfFilter[1] == "max"){
                    $filterToDisplay = $filterToDisplay . "Stock máximo: " . $splitedPartOfFilter[2] . "; ";
                }
            }
        }
        return $filterToDisplay;
    }

    // This function will take a raw string filter and return an array representing the filter
    public static function filterToArray(string $filter) {
        $splitedFilter = explode(";", $filter);
        $filterArr = ['priceMin' => '',
                      'priceMax' => '',
                      'discount' => false,
                      'discountMin' => '',
                      'discountMax' => '',
                      'stockMin' => '',
                      'stockMax' => '',
                      'categoria' => ''];
        foreach($splitedFilter as $partOfFilter){
            $splitedPartOfFilter = explode(":", $partOfFilter);
            if($splitedPartOfFilter[0] == "preco"){
                if($splitedPartOfFilter[1] == "min"){
                    $filterArr['priceMin'] = $splitedPartOfFilter[2];
                }
                else if($splitedPartOfFilter[1] == "max"){
                    $filterArr['priceMax'] = $splitedPartOfFilter[2];
                }
            }
            else if($splitedPartOfFilter[0] == "desconto"){
                if(sizeof($splitedPartOfFilter) == 1){
                    $filterArr['discount'] = true;
                }
                else if($splitedPartOfFilter[1] == "min"){
                    $filterArr['discountMin'] = $splitedPartOfFilter[2];
                }
                else if($splitedPartOfFilter[1] == "max"){
                    $filterArr['discountMax'] = $splitedPartOfFilter[2];
                }
            }
            else if($splitedPartOfFilter[0] == "stock"){
                if($splitedPartOfFilter[1] == "min"){
                    $filterArr['stockMin'] = $splitedPartOfFilter[2];
                }
                else if($splitedPartOfFilter[1] == "max"){
                    $filterArr['stockMax'] = $splitedPartOfFilter[2];
                }
            }
            else if($splitedPartOfFilter[0] == "categoria"){
                $filterArr['categoria'] = $splitedPartOfFilter[1];
            }
        }
        return $filterArr;
    }

        

    public static function filterFunctionFactory(string $filter){
        return function($product) use ($filter){
            $splitedFilter = explode(";", $filter);
            foreach($splitedFilter as $partOfFilter){
                $splitedPartOfFilter = explode(":", $partOfFilter);
                if($splitedPartOfFilter[0] == "preco"){
                    if($splitedPartOfFilter[1] == "min"){
                        if($product->precoatual*(1 - $product->desconto) < $splitedPartOfFilter[2]){
                            return false;
                        }
                    }
                    else if($splitedPartOfFilter[1] == "max"){
                        if($product->precoatual*(1 - $product->desconto) > $splitedPartOfFilter[2]){
                            return false;
                        }
                    }
                }
                else if($splitedPartOfFilter[0] == "desconto"){
                    if(sizeof($splitedPartOfFilter) == 1){
                        if($product->desconto == 0){
                            return false;
                        }
                    }
                    else if($splitedPartOfFilter[1] == "min"){
                        if($product->desconto < $splitedPartOfFilter[2]){
                            return false;
                        }
                    }
                    else if($splitedPartOfFilter[1] == "max"){
                        if($product->desconto > $splitedPartOfFilter[2]){
                            return false;
                        }
                    }
                }
                else if($splitedPartOfFilter[0] == "stock"){
                    if($splitedPartOfFilter[1] == "min"){
                        if($product->stock < $splitedPartOfFilter[2]){
                            return false;
                        }
                    }
                    else if($splitedPartOfFilter[1] == "max"){
                        if($product->stock > $splitedPartOfFilter[2]){
                            return false;
                        }
                    }
                }
                else if($splitedPartOfFilter[0] == "categoria"){
                    if($product->categoria != $splitedPartOfFilter[1]){
                        return false;
                    }
                }
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

    public static function filterProducts(string $filter){

        $filteredProducts = array_filter(Product::collectionToArray(Product::all()), Product::filterFunctionFactory($filter));

        return $filteredProducts;
    }

    public static function searchAndFilterProducts(string $stringToSearch, string $filter){
        $searchedProducts = Product::searchProducts($stringToSearch);
        $filteredProducts = array_filter(Product::collectionToArray($searchedProducts), Product::filterFunctionFactory($filter));
        return $filteredProducts;
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
}
