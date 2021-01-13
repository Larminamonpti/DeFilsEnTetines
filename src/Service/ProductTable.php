<?php

namespace App\Service;



class ProductTable {



    public function getTableAll($productsRepository, $imagesRepository){

        $table = [];
        $products = $productsRepository->findAll();
        $i=0;
        foreach($products as $product)
        {
            
            $table[$i] = [
                'id' => $product->getId(),
                'title' => $product->getTitle(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'type' => $product->getType(),
                'image' => $imagesRepository->findOneBy(['products' => $product->getId()])
        ];
            $i++;
        }
        return $table;
}
    public function getTableBy($productsRepository, $imagesRepository,$type){

        $table = [];
        $products = $productsRepository->findBy(['type' => $type->getId()]);
        $i=0;
        foreach($products as $product)
        {
            
            $table[$i] = [
                'id' => $product->getId(),
                'title' => $product->getTitle(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'type' => $product->getType(),
                'image' => $imagesRepository->findOneBy(['products' => $product->getId()])
        ];
            $i++;
        }
        return $table;
}
    public function getTableOneBy($productsRepository, $imagesRepository, $id){

        $table = [];
        $products = $productsRepository->findOneBy(['id' => $id]);
        $i=0;
        foreach($products as $product)
        {
            
            $table[$i] = [
                'id' => $product->getId(),
                'title' => $product->getTitle(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'type' => $product->getType(),
                'image' => $imagesRepository->findOneBy(['products' => $product->getId()])
        ];
            $i++;
        }
        return $table;
}

}

