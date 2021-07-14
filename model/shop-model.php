<?php 

//  

// Get one product entries
function getShopProducts(){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1';
                    #GROUP BY product_entry.productId'; Uncomment to only show one product_entry per product on shop page
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get one product entries by pagination
function getShopPaginations($lim, $offset){
    
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1  
                    ORDER BY product_entry.product_entryId 
                    LIMIT  :offset, :lim';
                    #GROUP BY product_entry.productId'; Uncomment to only show one product_entry per product on shop page
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':lim',$lim, PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination and size
function getShopColourPaginations($lim, $offset, $colour){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND colour.colour = :colour 
                    ORDER BY product_entry.product_entryId 
                    LIMIT  :offset, :lim';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':lim',$lim, PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination and size
function getShopSizePaginations($lim, $offset, $size){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND size.sizeValue = :size 
                    ORDER BY product_entry.product_entryId 
                    LIMIT  :offset, :lim';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':lim',$lim, PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}


//////////////////////////////////////////////////////////////////////
//                    Pagination filter start                       //
//////////////////////////////////////////////////////////////////////

// Get product entries by pagination and size
function getShopCategoryPaginations($lim, $offset, $category){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND categories.categoryName = :category 
                    ORDER BY product_entry.product_entryId 
                    LIMIT  :offset, :lim';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':lim',$lim, PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
    $stmt->bindValue(':category',$category, PDO::PARAM_STR);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination category and size
function getShopCategorySizePaginations($lim, $offset, $category, $size){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND categories.categoryName = :category 
                    AND size.sizeValue = :size
                    ORDER BY product_entry.product_entryId 
                    LIMIT  :offset, :lim';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':lim',$lim, PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
    $stmt->bindValue(':category',$category, PDO::PARAM_STR);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination category and colour
function getShopCategoryColourPaginations($lim, $offset, $category, $colour){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND categories.categoryName = :category 
                    AND colour.colour = :colour
                    ORDER BY product_entry.product_entryId 
                    LIMIT  :offset, :lim';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':lim',$lim, PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
    $stmt->bindValue(':category',$category, PDO::PARAM_STR);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination size and colour
function getShopSizeColourPaginations($lim, $offset, $size, $colour){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND size.sizeValue = :size 
                    AND colour.colour = :colour
                    ORDER BY product_entry.product_entryId 
                    LIMIT  :offset, :lim';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':lim',$lim, PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination size category and colour
function getShopSizeColourCategoryPaginations($lim, $offset, $size, $colour, $category){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND size.sizeValue = :size 
                    AND colour.colour = :colour
                    AND categories.categoryName = :category
                    ORDER BY product_entry.product_entryId 
                    LIMIT  :offset, :lim';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':lim',$lim, PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);
    $stmt->bindValue(':category',$category, PDO::PARAM_STR);


    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination size category price and colour
function getShopSizeColourCategoryPricePaginations($lim, $offset, $size, $colour, $category, $minPrice, $maxPrice){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND size.sizeValue = :size 
                    AND colour.colour = :colour
                    AND categories.categoryName = :category
                    AND :minPrice <= product_entry.price
                    AND :maxPrice > product_entry.price
                    ORDER BY product_entry.product_entryId 
                    LIMIT  :offset, :lim';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':lim',$lim, PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);
    $stmt->bindValue(':category',$category, PDO::PARAM_STR);
    $stmt->bindValue(':minPrice',$minPrice, PDO::PARAM_INT);
    $stmt->bindValue(':maxPrice',$maxPrice, PDO::PARAM_INT);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination size category price and colour
function getShopSizeColourPricePaginations($lim, $offset, $size, $colour, $minPrice, $maxPrice){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND size.sizeValue = :size 
                    AND colour.colour = :colour
                    AND :minPrice <= product_entry.price
                    AND :maxPrice > product_entry.price
                    ORDER BY product_entry.product_entryId 
                    LIMIT  :offset, :lim';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':lim',$lim, PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);
    $stmt->bindValue(':minPrice',$minPrice, PDO::PARAM_INT);
    $stmt->bindValue(':maxPrice',$maxPrice, PDO::PARAM_INT);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination size category price and colour
function getShopSizeCategoryPricePaginations($lim, $offset, $size, $category, $minPrice, $maxPrice){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND size.sizeValue = :size 
                    AND categories.categoryName = :category
                    AND :minPrice <= product_entry.price
                    AND :maxPrice > product_entry.price
                    ORDER BY product_entry.product_entryId 
                    LIMIT  :offset, :lim';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':lim',$lim, PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);
    $stmt->bindValue(':category',$category, PDO::PARAM_STR);
    $stmt->bindValue(':minPrice',$minPrice, PDO::PARAM_INT);
    $stmt->bindValue(':maxPrice',$maxPrice, PDO::PARAM_INT);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination category price and colour
function getShopColourCategoryPricePaginations($lim, $offset, $colour, $category, $minPrice, $maxPrice){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND colour.colour = :colour
                    AND categories.categoryName = :category
                    AND :minPrice <= product_entry.price
                    AND :maxPrice > product_entry.price
                    ORDER BY product_entry.product_entryId 
                    LIMIT  :offset, :lim';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':lim',$lim, PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);
    $stmt->bindValue(':category',$category, PDO::PARAM_STR);
    $stmt->bindValue(':minPrice',$minPrice, PDO::PARAM_INT);
    $stmt->bindValue(':maxPrice',$maxPrice, PDO::PARAM_INT);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination size category price and colour
function getShopSizePricePaginations($lim, $offset, $size, $minPrice, $maxPrice){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND size.sizeValue = :size 
                    AND :minPrice <= product_entry.price
                    AND :maxPrice > product_entry.price
                    ORDER BY product_entry.product_entryId 
                    LIMIT  :offset, :lim';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':lim',$lim, PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);
    $stmt->bindValue(':minPrice',$minPrice, PDO::PARAM_INT);
    $stmt->bindValue(':maxPrice',$maxPrice, PDO::PARAM_INT);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination size category price and colour
function getShopColourPricePaginations($lim, $offset, $colour, $minPrice, $maxPrice){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND colour.colour = :colour
                    AND :minPrice <= product_entry.price
                    AND :maxPrice > product_entry.price
                    ORDER BY product_entry.product_entryId 
                    LIMIT  :offset, :lim';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':lim',$lim, PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);
    $stmt->bindValue(':minPrice',$minPrice, PDO::PARAM_INT);
    $stmt->bindValue(':maxPrice',$maxPrice, PDO::PARAM_INT);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination size category price and colour
function getShopCategoryPricePaginations($lim, $offset, $category, $minPrice, $maxPrice){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND categories.categoryName = :category
                    AND :minPrice <= product_entry.price
                    AND :maxPrice > product_entry.price
                    ORDER BY product_entry.product_entryId 
                    LIMIT  :offset, :lim';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':lim',$lim, PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
    $stmt->bindValue(':category',$category, PDO::PARAM_STR);
    $stmt->bindValue(':minPrice',$minPrice, PDO::PARAM_INT);
    $stmt->bindValue(':maxPrice',$maxPrice, PDO::PARAM_INT);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

//////////////////////////////////////////////////////////////////////
//                     Pagination filter end                        //
//////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////
//                    Pagination filter start                       //
//////////////////////////////////////////////////////////////////////

// Get product entries by pagination and size
function getShopCategory($category){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND categories.categoryName = :category ';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':category',$category, PDO::PARAM_STR);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination category and size
function getShopCategorySize($category, $size){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND categories.categoryName = :category 
                    AND size.sizeValue = :size';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':category',$category, PDO::PARAM_STR);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination category and colour
function getShopCategoryColour($category, $colour){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND categories.categoryName = :category 
                    AND colour.colour = :colour';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':category',$category, PDO::PARAM_STR);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination size and colour
function getShopSizeColour($size, $colour){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND size.sizeValue = :size 
                    AND colour.colour = :colour';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination size category and colour
function getShopSizeColourCategory($size, $colour, $category){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND size.sizeValue = :size 
                    AND colour.colour = :colour
                    AND categories.categoryName = :category';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);
    $stmt->bindValue(':category',$category, PDO::PARAM_STR);


    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination size category price and colour
function getShopSizeColourCategoryPrice($size, $colour, $category, $minPrice, $maxPrice){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND size.sizeValue = :size 
                    AND colour.colour = :colour
                    AND categories.categoryName = :category
                    AND :minPrice <= product_entry.price
                    AND :maxPrice > product_entry.price';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);
    $stmt->bindValue(':category',$category, PDO::PARAM_STR);
    $stmt->bindValue(':minPrice',$minPrice, PDO::PARAM_INT);
    $stmt->bindValue(':maxPrice',$maxPrice, PDO::PARAM_INT);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination size category price and colour
function getShopSizeColourPrice($size, $colour, $minPrice, $maxPrice){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND size.sizeValue = :size 
                    AND colour.colour = :colour
                    AND :minPrice <= product_entry.price
                    AND :maxPrice > product_entry.price';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);
    $stmt->bindValue(':minPrice',$minPrice, PDO::PARAM_INT);
    $stmt->bindValue(':maxPrice',$maxPrice, PDO::PARAM_INT);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination size category price and colour
function getShopSizeCategoryPrice($size, $category, $minPrice, $maxPrice){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND size.sizeValue = :size 
                    AND categories.categoryName = :category
                    AND :minPrice <= product_entry.price
                    AND :maxPrice > product_entry.price';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);
    $stmt->bindValue(':category',$category, PDO::PARAM_STR);
    $stmt->bindValue(':minPrice',$minPrice, PDO::PARAM_INT);
    $stmt->bindValue(':maxPrice',$maxPrice, PDO::PARAM_INT);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination category price and colour
function getShopColourCategoryPrice($colour, $category, $minPrice, $maxPrice){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND colour.colour = :colour
                    AND categories.categoryName = :category
                    AND :minPrice <= product_entry.price
                    AND :maxPrice > product_entry.price';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);
    $stmt->bindValue(':category',$category, PDO::PARAM_STR);
    $stmt->bindValue(':minPrice',$minPrice, PDO::PARAM_INT);
    $stmt->bindValue(':maxPrice',$maxPrice, PDO::PARAM_INT);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination size category price and colour
function getShopSizePrice($size, $minPrice, $maxPrice){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND size.sizeValue = :size 
                    AND :minPrice <= product_entry.price
                    AND :maxPrice > product_entry.price';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);
    $stmt->bindValue(':minPrice',$minPrice, PDO::PARAM_INT);
    $stmt->bindValue(':maxPrice',$maxPrice, PDO::PARAM_INT);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination size category price and colour
function getShopColourPrice( $colour, $minPrice, $maxPrice){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND colour.colour = :colour
                    AND :minPrice <= product_entry.price
                    AND :maxPrice > product_entry.price';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);
    $stmt->bindValue(':minPrice',$minPrice, PDO::PARAM_INT);
    $stmt->bindValue(':maxPrice',$maxPrice, PDO::PARAM_INT);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get product entries by pagination size category price and colour
function getShopCategoryPrice($category, $minPrice, $maxPrice){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND categories.categoryName = :category
                    AND :minPrice <= product_entry.price
                    AND :maxPrice > product_entry.price';

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':category',$category, PDO::PARAM_STR);
    $stmt->bindValue(':minPrice',$minPrice, PDO::PARAM_INT);
    $stmt->bindValue(':maxPrice',$maxPrice, PDO::PARAM_INT);

    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

//////////////////////////////////////////////////////////////////////
//                     Pagination filter end                        //
//////////////////////////////////////////////////////////////////////

// Get product entries by pagination and size
function getShopPricePaginations($lim, $offset, $minPrice, $maxPrice){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1 
                    AND :minPrice <= product_entry.price 
                    AND product_entry.price <= :maxPrice';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':lim',$lim, PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
    $stmt->bindValue(':minPrice',$minPrice, PDO::PARAM_INT);
    $stmt->bindValue(':maxPrice',$maxPrice, PDO::PARAM_INT);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}



// Get products by common product Id
function getShopProduct($productId){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE product_entry.productId = :productId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':productId',$productId, PDO::PARAM_INT);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productData); exit;

    return $productData;
}

// Get one product entry
function getShopProductEntry($product_entryId){
    $db = zalistingConnect();
    $sql = 'SELECT product_entry.product_entryId, products.productId, products.productName, colour.colour, size.sizeValue, product_entry.price
                    FROM product_entry 
                    JOIN products ON product_entry.productId = products.productId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE product_entry.product_entryId = :product_entryId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':product_entryId',$product_entryId, PDO::PARAM_INT);
    $stmt->execute();
    $productData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productData); exit;

    return $productData;
}

// Get one product by colour and id
function getColourSwatchShopProduct($productId, $colour){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE product_entry.productId = :productId 
                    AND colour.colour = :colour';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':productId',$productId, PDO::PARAM_INT);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productData); exit;

    return $productData;
}

// Get one product by colour, size, and id
function getSizeSwatchedShopProduct($productId, $colour, $size){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE product_entry.productId = :productId 
                    AND colour.colour = :colour 
                    AND size.sizeValue = :size';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':productId',$productId, PDO::PARAM_INT);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productData); exit;

    return $productData;
}

// Get one product for swatches 
function getShopSwatchProduct($productId){
    $db = zalistingConnect();
    $sql = 'SELECT size.sizeValue, colour FROM product_entry 
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE product_entry.productId = :productId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':productId',$productId, PDO::PARAM_INT);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productData); exit;

    return $productData;
}

// Get product by categoryId 
function getProductByCategory($categoryId){ 
    $db = zalistingConnect(); 
    $sql = ' SELECT * FROM product WHERE categoryId = :categoryId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $product = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $product; 
   }

// Get product information by productId
function getProductItemInfo($productId){
    $db = zalistingConnect();
    $sql = 'SELECT * FROM products WHERE productId = :productId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
    $stmt->execute();
    $productInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $productInfo;
   }

// Get all products max price value
function getmaxPrice(){
    $db = zalistingConnect();
    $sql = 'SELECT price FROM product_entry ORDER BY price DESC LIMIT 1';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $max = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //echo $max['price']; exit;

    return $max['price'];
}

// Get all products min price value
function getminPrice(){
    $db = zalistingConnect();
    $sql = 'SELECT price FROM product_entry ORDER BY price ASC LIMIT 1';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $min = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //echo $min['price']; exit;

    return $min['price'];
}

// This function will update product
function deleteProduct($productId){
    
    // Create a connection object from the zalisting connection function
    $db = zalistingConnect(); 

    // The next line creates the prepared statement using the zalisting connection      
    $stmt = $db->prepare('DELETE FROM products WHERE productId = :productId');

    // Replace the place holder
    $stmt->bindValue(':productId',$productId, PDO::PARAM_INT);

    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();
    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
}

function getProductsByCategory($categoryName){
    $db = zalistingConnect();
    $sql = 'SELECT * FROM product_entry WHERE categoryId IN (SELECT categoryId FROM categories WHERE categoryName = :categoryName)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}

function getProductsByColour($colour){
    $db = zalistingConnect();
    $sql = 'SELECT * FROM product_entry WHERE colourId IN (SELECT colourId FROM colour WHERE colour = :colour)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':colour', $colour, PDO::PARAM_STR);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}

function getProductsByPrice($minPrice, $maxPrice){
    $db = zalistingConnect();
    
    $sql = 'SELECT * FROM product_entry 
            WHERE price >= :minPrice 
            AND price <= :maxPrice';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':minPrice', $minPrice, PDO::PARAM_INT);
    $stmt->bindValue(':maxPrice', $maxPrice, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}

function getProductsBySize($size){
    $db = zalistingConnect();
    $sql = 'SELECT * FROM product_entry WHERE sizeId IN (SELECT sizeId FROM size WHERE sizeValue = :size)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':size', $size, PDO::PARAM_STR);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}

// Get swatch images for a single product entry by product entry Id
function getSwatchImages($product_entryId){
    $db = zalistingConnect();
    $sql = 'SELECT imagePath, imagePath_tn FROM images 
                    WHERE product_entryId = :product_entryId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':product_entryId',$product_entryId, PDO::PARAM_INT);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productData); exit;

    return $productData;
}