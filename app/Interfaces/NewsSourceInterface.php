<?php 
namespace App\Interfaces;

interface NewsSourceInterface {
    public function fetchArticles(): array;
}