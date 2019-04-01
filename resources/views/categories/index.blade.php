@extends('layouts.app')

@section('content')
   <div class="d-flex justify-content-end mb-2">
     <a href="{{route('category.create')}}" class="btn btn-success">Add Category</a>
   </div>

   <div class="card card-default">
     <div class="card-header">categories</div>
      <div class="cart-body">
        <table class="table">
         <thead>
           <th>Name</th>
         </thead> 
         <tbody>
           @foreach($categories as $category)
             <tr>
               <td>
                 {{$category->name}}
               </td>
               <td>
                 <a href="{{route('category.edit', $category->id)}}" class="btn btn-info btn-sm">Edit</a>
                 <button  class="btn btn-danger btn-sm" onclick="handleDelete({{$category->id}})">Delete</button>

               </td>
             <tr/>
            @endforeach 
         </tbody> 
        </table>
          <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
           <form action="" method="Post" id="deleteCategoryDelete">
             @csrf
             @method('DELETE')
              <div class="modal-content">
              <div class="modal-header">
               <h5 class="modal-title" id="deleteMoodalLabel">Delete Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                 <p class="text-center">Are you sure you want to delete this category?</p>
              </div>
                <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Go Back</button>
                 <button type="submit" class="btn btn-danger">Delete</button>
             </div>
           </form>
           
          </div>
         </div>
        </div>
      </div>  
   </div>
@endsection

@section('scripts')
 <script>
    function handleDelete(id){
      var form = document.getElementById('deleteCategoryDelete');
      form.action = '/category/' + id;
       $('#deleteModal').modal('show')
      

      
    }
  </script>
@endsection
