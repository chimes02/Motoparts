 

<?php require_once '../partials/template.php'; ?>

<?php function get_page_content() { 
	if(!isset($_SESSION['user']) || (isset($_SESSION['user'])) && $_SESSION['user']['roles_id'] == 2) {
?>

<?php  require_once '../controller/connect.php'; 
		global $conn;
?>

<div class="container-fluid">
	<div class="row">

		<!-- categories -->
		<div class="col-sm-2">
			<!-- display categories -->
			<h2>Categories</h2>
			<ul class="list-group">
				<a href="catalog.php">
					<li class="list-group-item"> All </li>
				</a>
				<?php 
					$sql = "SELECT *FROM categories";
					$categories = mysqli_query($conn, $sql);

					foreach ($categories as $category) { ?>
						<a href="catalog.php?category_id=<?php echo $category['id']; ?>">
							<li class="list-group-item">
								<?php echo $category['name']; ?>
							</li>
						</a>
					<?php } ?>
			</ul>

			<h2>Sort</h2>
			<ul class="list-group">
				<a href="../controller/sort.php?sort=asc">
					<li class="list-group-item">
						Price(Lowest to highest)
					</li>
				</a>

				<a href="../controller/sort.php?sort=desc">
					<li class="list-group-item">
						Price(Highest to lowest)
					</li>
				</a>
			</ul>
		</div>

		<!-- items -->
		<div class="col-sm-10">
			<div class="container">
				<?php 
					$sql2 = "SELECT * FROM items";

					if(isset($_GET['category_id'])) {
						$sql2 .=" WHERE category_id =".$_GET['category_id'];
					}

					if(isset($_SESSION['sort'])) {
						// var_dump($_SESSION['sort']);
						$sql2 .= " " . $_SESSION['sort'];
					}

					// var_dump($sql2);

					$items = mysqli_query($conn, $sql2);

					echo "<div class='row'>";
					foreach ($items as $item) { ?>
						<div class="col-sm-3 mb-3" >
							<div class="card h-100">
								<img class="card-img-top" src="<?php echo $item['image_path']; ?>">
								<div class="card-body">
									<h4 class="card-title">
										<?php echo $item['name']; ?>
									</h4>
									<p class="card-text">
										<?php echo $item['description']; ?>
										<br>
										<?php echo $item['price']; ?>
									</p>
								</div>

							<!-- add to cart -->
							<div class="card-footer">
								<input type="number" name="" class="form-control" value="1">
								<button type="submit" class="btn btn-block btn-outlin-primary add-to-cart" data-id="<?php echo $item['id']; ?> ">
									Add to cart
								</button>
							</div>

							</div>
						</div> <!-- end card -->	
					<?php } echo "</div>" ; ?> <!-- end of items row -->
			</div> <!-- end items container-->
		</div> <!-- end items -->
		
	</div> <!-- end row -->
</div> <!-- end container -->


	<!-- // mysqli_close($conn); -->
<?php } else {
	header('Location: ./error.php');
} ?>


<?php } ?>