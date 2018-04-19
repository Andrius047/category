@foreach($cat as $category)
    <tr>
        <td>{{$category['category']}}</td>
        <td>@if($category['depth'] == 0) --- @else {{$categories[array_search($category['parent'], array_column($categories->toArray(), 'id'))]['category']}} @endif</td><br>
    </tr>
@endforeach
<br>

@foreach($tree as $category)
    @foreach($category as $sub)
    <tr>
        <td>{{$sub->category}}</td>
   </tr>
    @endforeach
@endforeach