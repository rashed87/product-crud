<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    public $active;
    public $q;
    public $sortBy = 'id';
    public $sortAsc = true;

    public $confirmingProductDeletion = false;
    public $confirmingProductAdd = false;

    protected $queryString = [
        'active' => [ 'except' => false ],
        'q' => [ 'except' => '' ],
        'sortBy' => [ 'except' => 'id' ],
        'sortAsc' => [ 'except' => true ]
    ];

    protected $rules = [
        'product.product_name' => 'required|string|min:4',
        'product.price' => 'required|numeric|between:1,100',
        'product.status' => 'boolean'
    ];

    public function render()
    {
        $products = Product::where( 'user_id', auth()->user()->id )
        ->when( $this->q, function( $query ){
            return $query->where( function( $query ){
                $query->where( 'product_name', 'like', '%'.$this->q.'%' )
                      ->orWhere( 'price', 'like', '%'.$this->q.'%' );
            });
        } )
        ->when( $this->active, function( $query ){
            return $query->active();
        })
        ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
        ;
        $products = $products->paginate( 10 );
        return view('livewire.products', [
            'products' => $products
        ] );
    }
    public function updatingActive()
    {
        $this->resetPage();
    }

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function sortBy( $field )
    {
        if( $field == $this->sortBy ){
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }
    public function confirmProductDeletion( $id )
    {
        //$product->delete();
        $this->confirmingProductDeletion = $id;
    }
    public function deleteProduct( Product $product )
    {
        $product->delete();
        $this->confirmingProductDeletion = false;
    }


    public function confirmProductAdd()
    {
        $this->confirmingProductAdd = true;
    }


}
