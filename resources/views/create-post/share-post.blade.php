@extends('create-post.app')
@section('content')
<share-post
:courseInfo="{{ $courseInfo ? json_encode($courseInfo) : null }}"
:subjectInfo="{{ $subjectInfo ? json_encode($subjectInfo) : null }}"
></share-post>
@endsection
