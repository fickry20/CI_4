<?php

namespace App\Controllers;
use App\Models\ProductModel;

class Products extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->findAll();
        // dd($data);
        return view('products/index', $data);
    }

    public function create()
    {
        return view('products/create');
    }

    public function store()
    {
        $productModel = new ProductModel();
        // Validasi dan upload file
        if ($imagefile = $this->request->getFile('product_images')) {
            if ($imagefile-> isValid() && !$imagefile->hasMoved()) {
                $newName = $imagefile->getRandomName();
                $imagefile->move(WRITEPATH . '../public/uploads', $newName);
            }
        }
        $data = [
            'nama'      =>$this->request->getPost('nama'),
            'price'     =>$this->request->getPost('price'),
            'ket'       =>$this->request->getPost('ket'),
            'kategori'  =>$this->request->getPost('kategori'),
            'images'    =>$this->request->getPost('images'),
        ];
        $productModel->insert($data);
        return redirect()->to('/product');
    }

    public function edit($id)
    {
        $productModel = new ProductModel();
        $data['product'] = $productModel -> find($id);

        return view('product/edit', $data);
    }

    public function update($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        $imagefile = $this->request->getFile('product_image');
        if ($imagefile && $imagefile->isValid() && !$imagefile->hasMoved()) {
            $newName = $imagefile->getRandomName();
            $imagefile->move(WRITEPATH . '../public/uploads', $newName);

            // Delete old image
            if ($product['image'] && file_exists(WRITEPATH . '../public/uploads' . $product['image'])) {
                unlink(WRITEPATH . '../public/uploads' . $product['images']);
            }
        } else {
            $newName = $product['image']; //keep old image if no new image upload
        };
        
        $data = [
            'nama'      =>$this->request->getPost('nama'),
            'price'     =>$this->request->getPost('price'),
            'ket'       =>$this->request->getPost('ket'),
            'kategori'  =>$this->request->getPost('kategori'),
            'image'     => $newName
        ];
    }
        public function delete($id)
        {
            $productModel = new ProductModel();
            $product = $productModel->find($id);

            // Delete Image
            if ($product['image'] &&  file_exists(WRITEPATH . '../public/uploads' . $product['image'])) {
                unlink(WRITEPATH . '../public/uploads' . $product['image']);
            }

            $productModel->delete($id);
            return redirect()->to('/products');
        

        $productModel->update($id, $data);
        return redirect() -> to('/product');
    }
}