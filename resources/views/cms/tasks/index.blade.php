@extends('cms.parent')

@section('styles')
    <link rel="stylesheet" href="{{ asset('cms/css/custom-task.css') }}">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">قائمة المهام</h3>
                <div class="card-tools">
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">إضافة مهمة جديدة</a>
                    <a href="{{ route('tasks.trashed') }}" class="btn btn-secondary btn-sm">سلة المهملات</a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العنوان</th>
                            <th>التصنيف</th>
                            <th>المستخدم</th>
                            <th>الحالة</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td><span class="badge bg-{{ $task->category->color ?? 'info' }}">{{ $task->category->name }}</span></td>
                            <td>{{ $task->user->name }}</td>
                            <td>
                                <span class="badge {{ $task->status == 'completed' ? 'badge-success' : 'badge-warning' }}">
                                    {{ $task->status == 'completed' ? 'مكتملة' : 'قيد الانتظار' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-info btn-sm">تعديل</a>
                                    <button type="button" onclick="confirmDestroy('/cms/tasks/{{$task->id}}', this)" class="btn btn-danger btn-sm">
                                        حذف
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection