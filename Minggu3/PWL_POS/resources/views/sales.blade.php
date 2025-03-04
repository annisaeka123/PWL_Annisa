<!DOCTYPE html> 
<html>
<head>
    <title>Sales</title>
</head>
<body>
    <h1>POS Sales</h1>
    <form>
        <label>Product:</label>
        <input type="text" name="product" placeholder="Enter product name">
        <label>Quantity:</label>
        <input type="number" name="quantity" min="1">
        <label>Price:</label>
        <input type="number" name="price" step="0.01">
        <button type="submit">Submit</button>
    </form>
    <br>
    <a href="/"><button>Back to Home</button></a>
</body>
</html>

