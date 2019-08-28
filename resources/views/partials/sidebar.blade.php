<div class="container px-3">
	<h2 class="text-center my-5">Best Recipes</h2>
	<ul class="best-list">
	  @foreach($top_recipes as $recipe)	
		<li class="best-recipe">

		 <div class="row">
			<div class="col-3">
				<img src="{{asset('/img/XS/' . $recipe->image)}}" alt="">
			</div>
			<div class="col-9">
				<div class="row justify-content-between px-0 mx-0">
					<h3>{{$recipe->title}}</h3>
					<span><i class="fas fa-star "></i> {{round($recipe->scores->avg('score'),1)}}</span>
				</div>
				<p class="px-0 mx-0">
					{{$recipe->description}}
				</p>
			</div>
		   </div>	
		</li>
	  @endforeach	
	</ul>
</div>