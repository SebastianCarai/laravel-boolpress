 @extends('layouts.dashboard')

 @section('content')
     <h1>Lista delle categorie</h1>

     <ul>
         @forelse ($categories as $category)
             <li>
                 <a href="{{ route('admin.categories.show' , ['category' => $category->slug]) }}">
                    <h4>{{ $category->name }}</h4>
                 </a>
             </li>
         @empty
             <li>
                <h3>Non ci sono Categorie</h3>
             </li>
         @endforelse
     </ul>
 @endsection