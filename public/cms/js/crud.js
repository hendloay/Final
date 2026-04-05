console.log("CRUD JS Loaded Successfully!");

// إعداد توكن الحماية لجميع طلبات Axios
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

/**
 * دالة الحفظ (Store)
 */
function performStore(url, data) {
    axios.post(url, data)
        .then(function (response) {
            Swal.fire({
                icon: 'success',
                title: 'تم الحفظ!',
                text: response.data.message,
                showConfirmButton: false,
                timer: 1500
            });
            setTimeout(() => { window.location.href = '/cms/tasks'; }, 1500);
        })
        .catch(function (error) {
            Swal.fire({
                icon: 'error',
                title: 'خطأ!',
                text: error.response.data.message
            });
        });
}

/**
 * دالة التحديث (Update)
 */
function performUpdate(url, data) {
    // نستخدم POST مع _method PUT لتجنب مشاكل بعض المتصفحات مع Axios.put
    data._method = 'PUT'; 
    axios.post(url, data)
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

/**
 * دالة تأكيد الحذف (العادي أو النهائي)
 */
function confirmDestroy(url, reference) {
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: "لا يمكن التراجع عن هذه الخطوة بسهولة!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'نعم، احذف!',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(url)
                .then(function (response) {
                    Swal.fire({
                        icon: response.data.icon || 'success',
                        title: response.data.title || 'تم الحذف!',
                        text: response.data.message || response.data.text,
                    });
                    reference.closest('tr').remove(); 
                })
                .catch(function (error) {
                    Swal.fire('خطأ!', 'حدث خطأ أثناء الحذف', 'error');
                });
        }
    })
}

/**
 * دالة تأكيد الاسترجاع (Restore)
 */
function confirmRestore(url, reference) {
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: "سيتم إعادة المهمة للقائمة الرئيسية!",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم، استرجعها!',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            performRestore(url, reference);
        }
    })
}

/**
 * تنفيذ عملية الاسترجاع
 */
function performRestore(url, reference) {
    axios.post(url)
        .then(function (response) {
            Swal.fire({
                icon: response.data.icon || 'success',
                title: response.data.title || 'تم الاسترجاع!',
                text: response.data.text || response.data.message,
                showConfirmButton: false,
                timer: 1500
            });
            // حذف السطر من جدول الأرشيف فوراً
            reference.closest('tr').remove();
        })
        .catch(function (error) {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'خطأ 404',
                text: 'الرابط غير صحيح أو المهمة غير موجودة'
            });
        });
}