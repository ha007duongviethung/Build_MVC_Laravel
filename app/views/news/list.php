<h1>List news</h1>
{{ $new_title }}<br>
{{  $new_content}}<br>
{{'Heroes Pluss'}}<br>
{{toSlug('Title Website')}}<br>
{! $new_auth !}<br>

@if(!empty($new_auth))
<p>Name Author: {{$new_auth}}</p>
@else
<p>Not Name</p>
@endif



@if(md5(12345)!='')
<h3>MD5: {{md5(12345)}}</h3>
@endif

@php 
$number = 2507;
echo $number . '<br>';
$unify = $number + 305;
$data = [
	'PHP',
	'Javascript',
	'Vuejs',
	'Laravel',
	'Golang',
	'Python',
];
@endphp
{{$unify}}<br>

@for($i = 1 ; $i < count($data) ; $i++)
<p>{{$data[$i]}}</p>
@endfor

@php
$i = 0;
@endphp

@while ($i <= 10)
<p>{{$i}}</p>
@php
$i++;
@endphp
@endwhile

@foreach($data as $key => $value)
<p>Key: {{$key}} - Value: {{$value}}</p>
@endforeach