

/** Add To Cart **/
$('.addToCartBtn').on('click', function() {
    // console.log($(this).data('p'));
    let addToCartBtn = $(this);
    addToCartBtn.addClass("button--disable");
    let data = {
        "p": $(this).data('p'),
    }
    // $.post($(this).data('url'), data,function (response, textStatus, jqXHR) {
    //     $('meta[name="csrf-token"]').attr('content', response.token);
    //     console.log(response);
    // });

    $.ajax({
        type: "post",
        url: $(this).data('url'),
        data: {
            "p": $(this).data('p'),
        },
        // dataType: "dataType",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response,textStatus, jqXHR) {
            $('meta[name="csrf-token"]').attr('content', response.token);
            addToCartBtn.removeClass("button--disable");
            $('.cart-bag span.item-number').text(response.total_qty);
            // console.log(response);
            alert("Ürün sepetinize eklendi");
        }
    });
});

/** Remove To Cart **/
$('.delete-item').on('click',function(){
    let removeItemBtn = $(this);
    removeItemBtn.addClass("button--disable");
    let data = {
        "p": $(this).data('p'),
    }
    $.ajax({
        type: "post",
        url: $(this).data('url'),
        data: {
            "p": $(this).data('p'),
        },
        // dataType: "dataType",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response,textStatus, jqXHR) {
            // console.log(textStatus, jqXHR);
            window.location.reload();
        }
    });
});

function increment(incBtn) {
    // console.log(incBtn);
    // let counter = document.getElementById('counter-btn-counter');
    // counter = incBtn.parentElement.firstChild.nextSibling.nextSibling.nextSibling;
    let counter = incBtn.parentElement.children[1];
    counter.stepUp();

    // console.log(incBtn.getAttribute("data-url"));
    // incBtn.classList.add("button--disable");
    incBtn.classList.add("button--disable");

    $.ajax({
        type: "post",
        url: incBtn.getAttribute("data-url"),
        data: {
            "p": incBtn.getAttribute('data-p'),
            "qty": counter.value
        },
        // dataType: "dataType",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response,textStatus, jqXHR) {
            // $('meta[name="csrf-token"]').attr('content', response.token);
            // element.removeClass("button--disable");
            // $('.cart-bag span.item-number').text(response.total_qty);
            // console.log(response);
            window.location.reload();
        }
    });
}

function decrement(incBtn) {
    // let counter = document.getElementById('counter-btn-counter');
    let counter = incBtn.parentElement.children[1];
    counter.stepDown();

    incBtn.classList.add("button--disable");

    $.ajax({
        type: "post",
        url: incBtn.getAttribute("data-url"),
        data: {
            "p": incBtn.getAttribute('data-p'),
            "qty": counter.value
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response,textStatus, jqXHR) {
            window.location.reload();
        }
    });
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


if(document.getElementById('settingsForm')){
    let form = '#settingsForm';
    $(form).on('submit', function(event) {
        event.preventDefault();
        let form_url = $(this).attr('action');
        const btnSave = event.target.querySelector('#settingsUpdate');
        btnSave.disabled = true;

        //console.log(new FormData(this));
        $.ajax({
            url: form_url,
            method: 'POST',
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                Swal.fire({
                    icon: response.status,
                    title: response.title,
                    html: response.message,
                    timer: 1500
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if ((result.isConfirmed || result.dismiss) && response
                        .status == "success") {
                        window.location.href = response.redirect;
                    }
                })
                btnSave.disabled = false;
            },
            error: function(response) {
                if (response.responseJSON) {
                    let swaltext = "";
                    $.each(response.responseJSON.errors, function(indexInArray,
                        valueOfElement) {
                        $.each(valueOfElement, function(key, value) {
                            swaltext += value + "<br>";
                        });
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Hata...',
                        html: swaltext,
                        timer: 1500
                    })

                    btnSave.disabled = false;
                }

            }
        });
    });
}

$('.passwordChange').on('click',function(){
    // console.log(new FormData($('#passwordForm').submit()));
    // console.log($('#passwordForm').serialize());
    // console.log($('#passwordForm').serializeArray());
    let form_url = $('#passwordForm').attr('action');
    const btnSave = $(this);
    btnSave.disabled = true;

    $.ajax({
        url: form_url,
        method: 'POST',
        data: $('#passwordForm').serializeArray(),
        dataType: 'JSON',
        // contentType: false,
        cache: false,
        processData: true,
        success: function(response) {
            Swal.fire({
                icon: response.status,
                title: response.title,
                html: response.message,
                timer: 1500
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if ((result.isConfirmed || result.dismiss) && response
                    .status == "success") {
                    window.location.href = response.redirect;
                }
            })
            btnSave.disabled = false;
        },
        error: function(response) {
            if (response.responseJSON) {
                let swaltext = "";
                $.each(response.responseJSON.errors, function(indexInArray,
                    valueOfElement) {
                    $.each(valueOfElement, function(key, value) {
                        swaltext += value + "<br>";
                    });
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Hata...',
                    html: swaltext,
                    timer: 1500
                })

                btnSave.disabled = false;
            }

        }
    });
})
