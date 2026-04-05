@extends('cms.parent')

@section('styles')
    <link rel="stylesheet" href="{{ asset('cms/css/custom-task.css') }}">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-info mt-3">
            <div class="card-header">
                <h3 class="card-title">تعديل المهمة: {{ $task->title }}</h3>
            </div>
            <form id="edit-form">
                <div class="card-body">
                    <div class="form-group">
                        <label>عنوان المهمة</label>
                        <input type="text" id="title" class="form-control" value="{{ $task->title }}">
                    </div>

                    <div class="form-group">
                        <label>التصنيف</label>
                        <select id="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if($task->category_id == $category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>الحالة</label>
                        <select id="status" class="form-control">
                            <option value="pending" @if($task->status == 'pending') selected @endif>قيد الانتظار</option>
                            <option value="completed" @if($task->status == 'completed') selected @endif>مكتملة</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>الوصف</label>
                        <textarea id="description" class="form-control" rows="3">{{ $task->description }}</textarea>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="button" onclick="updateTask()" class="btn btn-info">تحديث البيانات</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-default">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function updateTask() {
        let data = {
            _method: 'PUT', 
            title: document.getElementById('title').value,
            category_id: document.getElementById('category_id').value,
            status: document.getElementById('status').value,
            description: document.getElementById('description').value,
            user_id: "{{ $task->user_id }}", 
        };

        axios.post('/cms/tasks/{{ $task->id }}', data)
            .then(function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'تم التعديل!',
                    text: response.data.message,
                    timer: 1500
                });
                setTimeout(() => { window.location.href = '/cms/tasks'; }, 1500);
            })
            .catch(function (error) {
                Swal.fire({ 
                    icon: 'error', 
                    title: 'فشل التحديث', 
                    text: error.response.data.message 
                });
            });
    }
</script>
@endsection