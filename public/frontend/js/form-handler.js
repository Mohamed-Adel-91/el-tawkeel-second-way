export default function handleForm(form, url, { onBefore, onSuccess, onError, onFieldError } = {}) {
    if (!form || !url) return;

    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    if (token && window.axios) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (typeof onBefore === 'function') {
            onBefore(form);
        }
        const formData = new FormData(form);
        window.axios.post(url, formData)
            .then(res => {
                Swal.fire({
                    icon: 'success',
                    text: res.data.message || 'تم الإرسال بنجاح',
                    confirmButtonColor: '#d03b37',
                });
                if (typeof onSuccess === 'function') {
                    onSuccess(res, form);
                }
            })
            .catch(err => {
                if (err.response && err.response.status === 422) {
                    const errors = err.response.data.errors || {};
                    Object.keys(errors).forEach(field => {
                        if (typeof onFieldError === 'function') {
                            onFieldError(field, errors[field][0], form);
                        }
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في التحقق',
                        html: Object.values(errors).flat().join('<br>'),
                        confirmButtonColor: '#d03b37',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: 'تعذر الاتصال بالخادم',
                        confirmButtonColor: '#d03b37',
                    });
                }
                if (typeof onError === 'function') {
                    onError(err, form);
                }
            });
    });
}
