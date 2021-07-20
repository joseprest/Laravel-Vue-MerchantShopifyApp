
function clearErrors(form = null) {
    if(!form) form = 'body'
    $(form).find(".alert-danger").remove();
}
window.clearErrors = clearErrors;

function showErrors(form = null, errors) {
    clearErrors(form);
    console.log(errors);
    if(!form) form = 'body'
    let errorHTML = '<span class="alert-danger input-error"></span>';
    if (errors) {
        $.map(errors, function (error, name) {
            if(typeof error === 'array') error = error[0].replace(/\./g, ' ')
            let inputElement = $(form).find("[name='" + name + "']").first();
            if (inputElement) {
                let errorElement = $(errorHTML).html(inputElement.attr('display-name') || error)
                inputElement.parent().append(errorElement);
                inputElement.click(function () {
                    errorElement.remove();
                });
                inputElement.focus(function () {
                    errorElement.remove();
                });
            }
        });
    }
}
window.showErrors = showErrors;

window.successToast = function (body = "Settings saved successfully") {
    this.$bvToast.toast(body, {
        title: "Success!",
        toaster: 'b-toaster-bottom-right',
        variant: 'success',
        autoHideDelay: 5000,
        appendToast: true
    })    
}
window.dangerToast = function (body = "Settings not saved. Please try again.") {
    this.$bvToast.toast(body, {
        title: "Whoops!",
        toaster: 'b-toaster-bottom-right',
        variant: 'danger',
        autoHideDelay: 5000,
        appendToast: true
    })    
}