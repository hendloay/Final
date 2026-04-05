@extends('cms.parent')

@section('styles')
    <link rel="stylesheet" href="{{ asset('cms/css/custom-task.css') }}">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary mt-3">
            <div class="card-header">
                <h3 class="card-title">إضافة مهمة جديدة</h3>
            </div>
            <form id="create-form">
                <div class="card-body">
                    <div class="form-group">
                        <label>عنوان المهمة</label>
                        <input type="text" id="title" class="form-control" placeholder="أدخل العنوان">
                    </div>
                    <div class="form-group">
                        <label>التصنيف</label>
                        <select id="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>صاحب المهمة</label>
                        <select id="user_id" class="form-control">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>الحالة</label>
                        <select id="status" class="form-control">
                            <option value="pending">قيد الانتظار</option>
                            <option value="completed">مكتملة</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>الوصف</label>
                        <textarea id="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" onclick="save()" class="btn btn-primary">حفظ المهمة</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function save() {
        let data = {
            title: document.getElementById('title').value,
            category_id: document.getElementById('category_id').value,
            user_id: document.getElementById('user_id').value,
            status: document.getElementById('status').value,
            description: document.getElementById('description').value,
        };

        performStore('/cms/tasks', data);
    }
</script>
@endsection