@extends('create-post.app')
@section('content')
<share-post
:course-info="{{ json_encode($courseInfo) }}"
:subject-info="{{ json_encode($subjectInfo) }}"
></share-post>
@endsection
