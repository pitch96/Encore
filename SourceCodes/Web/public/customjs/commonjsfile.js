$(document).on('click', '.popular-status', function() {
    let url = $(this).data('delete_url');
    let msg = $(this).data('delete_msg');

    if(url == ""){
        Swal.fire({
            title: 'Action not applicable!',
            text: msg,
            icon: 'error',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok!'
        }).then((res) => {
            if(res.isConfirmed) {
                window.location.reload();
            } else {
                window.location.reload();
            }
        })
    } else {
    Swal.fire({
        title: 'Are you sure?',
        text: msg,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Change Status'
    }).then((result) => {
        if (result.isConfirmed){
            $.ajax({
                method: "get",
                dataType: "json",
                url: url,
                success: function (response) {
                    if (response.status === true) {
                        Swal.fire({
                            title: 'Popularity Status changed',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload();
                            } else {
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Somethings wrong!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload();
                            } else {
                                window.location.reload();
                            }
                        });
                    }
                }
            })
        } else {
            window.location.reload();
        }
    })
}
    });

$(document).on('click', '.cancel-event', function () {
    let url = $(this).data('delete_url');
    let msg = $(this).data('delete_msg');
    Swal.fire({
        title: 'Are you sure?',
        text: msg,
        // html: buttons,
        icon: 'warning',
        input: 'textarea',
        inputPlaceholder: 'Reason for cancelling the event?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        cancelButtonText: 'No!'
    }).then((result) => {
        if(result.isConfirmed) {
            let reason = result.value;
            if(!reason) {
                alert('plesase enter a valid reason  to cancel the event');
                return false;
            } else {
                $.ajax({
                    method: "post",
                dataType: 'json',
                url: url,
                data : {
                    reason: reason
                },
                success: function (response) {
                    console.log(response);
                    if (response.status === true) {
                        Swal.fire({
                            title: 'Event Cancelled',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            if(result.isConfirmed) {
                                window.location.reload();
                            } else {
                                window.location.reload();
                            }
                        })
                    } else {
                        console.log(response);
                        Swal.fire({
                            title: 'Something went wrong!',
                            text: response.message,
                            icon: 'warning',
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            } else {
                                window.location.reload();
                            }
                        })
                    }
                }
            });
        }
        } else {
            window.location.reload();
        }
    })
});

$(document).on('click', '.check-reason', function () {
    let reason = $(this).data('reason_msg');

    Swal.fire({
        title: "<h5 style='color:red;'><b>Cancelling Reason</b></h5>",
        text: reason,
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Close'
    });
});

$(document).on('click', '.delete-data', function () {
    let url = $(this).data('delete_url');
    let msg = $(this).data('delete_msg');

    Swal.fire({
        title: 'Are you sure?',
        text: msg,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "get",
                dataType: 'json',
                url: url,
                success: function (response) {
                    if (response.status === true) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload();
                            } else {
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Somethings wrong!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload();
                            } else {
                                window.location.reload();
                            }
                        });
                    }
                }
            });
        } else {
            window.location.reload();
        }
    })
});


$(document).on('click', '.change-verify-status' , function () {
    let url = $(this).data('delete_url');
    let msg = $(this).data('delete_msg');
    Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: msg,
        showCancelButton: true,
        confirmButtonText: 'Change Status',
        cancelButtonColor: '#d33'
    }).then(function(result) {
        if (result.isConfirmed) {
            $.ajax({
                method: "get",
                dataType: 'json',
                url: url,
                success: function (response) {
                    console.log(response);
                    if (response.status === 'success') {
                        Swal.fire({
                            title: 'Status Changed!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload();
                            } else {
                                window.location.reload();
                            }
                        });

                    } else {
                        Swal.fire({
                            title: 'Somethings wrong!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload();
                            } else {
                                window.location.reload();
                            }
                        });
                    }
                }
            });
        } else {
            window.location.reload();
            
        }
    })
});


$(document).on('click', '.change-status', function () {
    let url = $(this).data('delete_url');
    let route = $(this).data('get_access');
    let msg = $(this).data('delete_msg');
    if (url == '') {
        if (route) {
            Swal.fire({
                icon: 'warning',
                title: 'Need Permission',
                text: msg,
                showCancelButton: true,
                confirmButtonText: 'Get Access',
                cancelButtonColor: '#d33',
            }).then(function(result) {
                if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.reload();
                } else {
                    location.href = route;
                }
            })
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Need Permission',
                text: msg,
                showCancelButton: true,
                confirmButtonText: 'Ok',
                cancelButtonColor: '#d33',
            }).then((result) => {
                window.location.reload();
            })
        }
    } else {
        Swal.fire({
            title: 'Are you sure?',
            text: msg,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "get",
                    dataType: 'json',
                    url: url,
                    success: function (response) {
                        if (response.status === true) {
                            Swal.fire({
                                title: 'Status Changed!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((res) => {
                                if (res.isConfirmed) {
                                    window.location.reload();
                                } else {
                                    window.location.reload();
                                }
                            });

                        } else {
                            Swal.fire({
                                title: 'Somethings wrong!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then((res) => {
                                if (res.isConfirmed) {
                                    window.location.reload();
                                } else {
                                    window.location.reload();
                                }
                            });
                        }
                    }
                });
            } else {
                window.location.reload();
            }
        })
    }

});

$(document).on('click', '.permission-response', function () {
    let url = $(this).data('response_url');
    let msg = $(this).data('response_msg');

    Swal.fire({
        title: 'Are you sure?',
        text: msg,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('response');
            $.ajax({
                method: "get",
                dataType: 'json',
                url: url,
                success: function (response) {
                    console.log(response);
                    if (response.status === 1) {
                        Swal.fire({
                            title: 'Permission Response',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload();
                            } else {
                                window.location.reload();
                            }
                        });

                    } else {
                        Swal.fire({
                            title: 'Somethings wrong!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload();
                            } else {
                                window.location.reload();
                            }
                        });
                    }
                }
            });
        } else {
            window.location.reload();
        }
    })
});

$(document).on('click', '.refund-promotionalCharge', function() {
    var msg = $(this).data('delete_msg');
    var url = $(this).data('delete_url');
    Swal.fire({
        title: 'Are you sure?',
        text: msg,
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        confirmButtonColor: '#3085d6',
    }).then((res) => {
        if(res.isConfirmed) {
            $.ajax({
                method: "GET",
                url: url,
                success: function(res) {
                    Swal.fire({
                        title: 'Refunded',
                        text: res.message,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'Ok!',
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        if(result.isConfirmed) {
                            window.location.reload();
                        } else {
                            window.location.reload();
                        }
                    })
                }
            });
        } else {
            window.location.reload();
        }
    })
});
