<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;

class Product extends Model{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = 'produto';

    protected $fillable = [
        'nome',
        'descricao',
        'precoAtual',
        'desconto',
        'stock',
        'id_administrador'
    ];

    public static function searchProducts(string $stringToSearch){
        $searchTemperature = 0.5;
        $searchedProducts = DB::table('produto')
                            ->whereRaw("ts_rank(tsvectors, plainto_tsquery('portuguese', ?)) > ?", [$stringToSearch, $searchTemperature])
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
}
