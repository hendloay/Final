@extends('cms.parent')

@section('content')
<div class="card mt-3 mx-3">
    <div class="card-header bg-dark"><h3 class="card-title">الأرشيف</h3></div>
    <div class="card-body p-0">
        <table class="table table-hover">
            <thead>
                <tr><th>المهمة</th><th>تاريخ الحذف</th><th>العمليات</th></tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->deleted_at->format('Y-m-d') }}</td>
                    <td>
                        <button type="button" onclick="confirmRestore('/cms/tasks-restore/{{$task->id}}', this)" class="btn btn-success btn-sm">استرجاع</button>
                        <button type="button" onclick="confirmForceDelete('/cms/tasks-force/{{$task->id}}', this)" class="btn btn-danger btn-sm">حذف نهائي</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center">السلة فارغة</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmRestore(url, reference) {
        Swal.fire({
            title: 'استرجاع؟', icon: 'info', showCancelButton: true, confirmButtonText: 'نعم'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(url).then(res => {
                    Swal.fire('تم!', res.data.text, 'success');
                    reference.closest('tr').remove();
                }).catch(err => { Swal.fire('خطأ', 'فشل الاسترجاع', 'error'); });
            }
        });
    }

    function confirmForceDelete(url, reference) {
        Swal.fire({
            title: 'حذف نهائي؟', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'حذف'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(url).then(res => {
                    Swal.fire('تم!', res.data.text, 'success');
                    reference.closest('tr').remove();
                }).catch(err => { Swal.fire('خطأ', 'فشل الحذف', 'error'); });
            }
        });
    }
</script>
@endsection