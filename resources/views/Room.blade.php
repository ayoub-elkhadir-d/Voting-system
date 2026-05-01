<div>
<form action ="{{route('createroom')}}" method= "Post" >
    @csrf
    <input type="text" name="name">
    <input type="description" name="desc">
    <input type="number" name="capacity">
    <input type="text" name="privacy">
   <button>submte</button>
</form>
    
</div>
