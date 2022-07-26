<?php
$products = file_get_contents("products.json");
$products = json_decode($products);

if(isset($_GET['xml']))
{
    $xml_data_format = createXMLFile($products);

    header("Content-disposition: attachment; filename=$xml_data_format");
    header('Content-type:xml/text; charset="utf8"');
    readfile($xml_data_format);

} elseif(isset($_GET['json']))
{ 
    $json_file_path = createJsonFile($products);

    header("Content-disposition: attachment; filename=$json_file_path");
    header("Content-type: application/json; charset='utf8'");
    readfile($json_file_path);

    
}

function createXMLFile($products)
{
   
	$dom = new DOMDocument();

    $dom->encoding = 'utf-8';

    $dom->xmlVersion = '1.0';

    $dom->formatOutput = true;

    $xml_file_name = 'product_list.xml';

    $root = $dom->createElement('Products');


    foreach($products as $product)
    {
        $id = $product->id;
        $product_name = $product->name;
        $price = $product->price;
        $category = $product->category;

        $product_node = $dom->createElement('product');

        $child_node_id = $dom->createElement('ID', $id);

            $product_node->appendChild($child_node_id);

        $child_node_name = $dom->createElement('ProductName', $product_name);

            $product_node->appendChild($child_node_name);

        $child_node_price = $dom->createElement('Price', $price);

            $product_node->appendChild($child_node_price);

        $child_node_category = $dom->createElement('Category', $category);

            $product_node->appendChild($child_node_category);

        $root->appendChild($product_node);

        $dom->appendChild($root);
    }
    
    $dom->save($xml_file_name);

    return $xml_file_name;
}

function createJsonFile($products)
{
    foreach($products as $product)
    {
        $json_products [] = 
        array (
            'id' => $product->id,
            'product_name' => $product->name,
            'price' => $product->price,
            'category' => $product->category
        );
    }
    
    $json_format_products = json_encode($json_products);

    $file_path = "product_list.json"; 
    file_put_contents($file_path, $json_format_products);
    
    return $file_path;
}
