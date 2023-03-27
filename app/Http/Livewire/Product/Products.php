<?php

namespace App\Http\Livewire\Product;
use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;
use Flasher\Prime\FlasherInterface;

class Products extends Component
{
    use WithPagination;

    public $product;
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
        return view('livewire.product.products', [
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
        $this->confirmingProductDeletion = $id;
    }
    public function deleteProduct( Product $product, FlasherInterface $flasher )
    {
        $product->delete();
        $this->confirmingProductDeletion = false;
        $flasher->addSuccess('The product was removed successfully.');
    }


    public function confirmProductAdd()
    {
        $this->confirmingProductAdd = true;
    }
    public function createProduct( FlasherInterface $flasher )
    {
        $this->validate();

        auth()->user()->products()->create([
            'product_name' => $this->product['product_name'],
            'price' => $this->product['price'],
            'status' => $this->product['status'] ?? 0
        ]);
        $this->confirmingProductAdd = false;
        $this->reset(['product']);
        $flasher->addSuccess('The product was created successfully.');
    }


}
