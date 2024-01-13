import './bootstrap';
window.toastr = toastr;

// Optional: Set default options for Toastr
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: 'toast-top-right',
    timeOut: 3000 // Time in milliseconds
};