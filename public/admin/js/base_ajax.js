
// Helper Url
function route(url, param = null) {
    if(!param) return null;
    return url.replace(
        ':id',
        param
    )
}

// Helper Ajax
function ajaxRequest(url, method = 'GET', data = {}, options = {}) {
    const {
        reload = null,
        successMessage = "Operasi berhasil",
        errorMessage = "Terjadi kesalahan!",
        onSuccess = () => {},
        onError = () => {},
        complete = () => {} ,
        silent = false,
        headers = {}
    } = options;

    if (method !== 'GET' && method !== 'POST') {
        if (data instanceof FormData) {
            data.append('_method', method);  
        } else {
            data._method = method;
        }
        method = 'POST';
    }
    $.ajax({
        url,
        method: method,
        data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            ...headers
        },
        processData: !(data instanceof FormData),
        contentType: data instanceof FormData ? false : 'application/x-www-form-urlencoded; charset=UTF-8',
        success: (res) => {
            if (!silent) {
                Swal.fire({
                    type: 'success',
                    title: 'Berhasil!',
                    text: successMessage,
                    showConfirmButton: false,
                    timer: 1500,          
                    timerProgressBar: true
                });
            }
            onSuccess(res)

            if(reload) {
                $(reload).DataTable().ajax.reload(null, false);
            }
            
        },
        error: (err) => {
            Swal.fire('Gagal!', err.responseJSON?.message || errorMessage, 'error');
            onError(err)
        },
        complete: function() {
            complete();   
        }
    })
}