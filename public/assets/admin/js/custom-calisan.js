$(document).ready(function () {

    // ajax setup
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    if(document.getElementById('table1')){
        /* Jquery DataTable */
        let table = $("#table1 tbody");
        let dataUrl = $('#table1').data("url");
        let jquery_datatable = $("#table1").DataTable({
            columnDefs:[
                // {
                //     targets: ['nosort'],
                //     orderable: false
                // },
                {
                    // target:[2],
                    // target:[0,1,2],
                    // orderable:false
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All']
            ],
            order:[
                // [2,'desc']
                [1,'desc']
            ],
            // "pageLength": 1,
            // "language": {
            //     //DataTable'ın dilini Türkçeleştir
            //     "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
            // },
            // info: false,
            // ordering: false,
            // paging: false
            // ajax: '../server_side/scripts/server_processing.php',
            // ajax: dataUrl,
            ajax: {
                url: dataUrl,
                // dataSrc: 'data',
                type: "post",
                // dataSrc: function(response){
                //     console.log(response);
                // }
                /*
                success:function(response){
                    console.log(response.data);

                    table.empty();

                    $.each(response.data, function (key, value) {
                        console.log(value);
                        table.append("<tr><td>"+value.name+"</td>"+
                            "<td>"+value.created_at+"</td>"+
                                 "<td> <button class='btn btn-success'>Yetki</button></td></tr>");
                    });

                    $("#table1").DataTable();
                }
                */
                //success:function(response){
                  //  console.log(response);

                    // table.empty();
                    // $.each(response.data, function (a, b) {
                    //     table.append("<tr><td>"+b.name+"</td>"+
                    //         "<td>"+b.created_at+"</td>"+
                    //         "<td> <button class='btn btn-success'>Yetki</button></td></tr>");
                    // });

                    // $("#table1").DataTable();

                    /*
                    $.each(data, function (a, b) {
                        table.append("<tr><td>"+b.CannonicalName+"</td>"+
                            "<td>"+b.SamAccountName+"</td>"+
                             "<td>"+b.UserAccountCode+"</td>"+
                              "<td>"+b.UserAccountControl+"</td>"+
                               "<td>"+b.LastLogon+"</td>"+
                                "<td>"+b.WhenCreated+"</td>"+
                                 "<td>"+b.PwdLastSet+"</td>"+
                                 "<td> <button class='btn btn-success'>Yetki</button></td></tr>");
                    });
                    */
                //},
                // error:function(error){
                //     console.log(error);
                // }
            },
            processing: true,
            serverSide: true,
            // "columns":[
            //     {'data':'name'},
            //     {'data':'created_at'},
            // ]
        });

        // new DataTable('#table1', {
        //     info: false,
        //     ordering: false,
        //     paging: false
        // });
    }

    if(document.getElementById('Form')){
        let form = '#Form';
        $(form).on('submit', function(event) {
            event.preventDefault();

            let form_url = $(this).attr('action');
            const btnSave = event.target.querySelector('#btnSave');
            btnSave.disabled = true;

            //console.log(new FormData(this));

            $.ajax({
                url: form_url,
                method: 'POST',
                data: new FormData(this),
                // data: {
                //     data: '1'
                // },
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    // $(form).trigger("reset");
                    // alert(response.success)
                    // console.log(response);
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
                                // console.log(value);
                                swaltext += value + "<br>";
                            });
                        });

                        // console.log(swaltext);

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



    if(document.querySelector('.choices')){
      /* Form Select */
      let choices = document.querySelectorAll(".choices");
      let initChoice;
      for (let i = 0; i < choices.length; i++) {
          if (choices[i].classList.contains("multiple-remove")) {
              initChoice = new Choices(choices[i], {
                  delimiter: ",",
                  editItems: true,
                  maxItemCount: -1,
                  removeItemButton: true,
              });
          } else {
              initChoice = new Choices(choices[i]);
          }
      }
    }


    $('table').on('click','.btnDelete',function(){
        // let $data_id = $(this).data('id');
        let dataUrl = $(this).data('url');
        // let process = $(this).parent();
        // let form = document.createElement("form");
        // form.setAttribute('src',dataUrl);
        // let method = document.createElement("input");
        // method.setAttribute('name','_method');
        // method.setAttribute('value','DELETE');
        // form.appendChild(method);

        Swal.fire({
            title: 'Uyarı!',
            text: "Kaydı Silmek istediğinize emin misiniz?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet, Sil'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: dataUrl,
                    method: 'DELETE',
                    //data: new FormData(form),
                    // data: {
                    //     data: '1'
                    // },
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        // $(form).trigger("reset");
                        // alert(response.success)
                        // console.log(response);
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
                        // btnSave.disabled = false;
                    },
                    error: function(response) {
                        if (response.responseJSON) {
                            let swaltext = "";
                            $.each(response.responseJSON.errors, function(indexInArray,
                                valueOfElement) {
                                $.each(valueOfElement, function(key, value) {
                                    // console.log(value);
                                    swaltext += value + "<br>";
                                });
                            });

                            // console.log(swaltext);

                            Swal.fire({
                                icon: 'error',
                                title: 'Hata...',
                                html: swaltext,
                                timer: 1500
                            })


                            // btnSave.disabled = false;
                        }

                    }
                });
            //   Swal.fire(
            //     'Deleted!',
            //     'Your file has been deleted.',
            //     'success'
            //   )
            }
          })

    });



    /* Kayıt aktif - pasif yapma */
$('table').on("change", ".statusChange", function () {
	// let $data = $(this).attr("checked");
	let $data = $(this).prop("checked");
	// let $data = $(this).is(":checked");
	let $data_url = $(this).data("url");

    $.ajax({
        url: $data_url,
        method: 'PATCH',
        data: {'status': $data},
        dataType: 'JSON',
        success: function(response) {
        },
        error: function(response) {
        }
    });
});



});

// document.addEventListener("DOMContentLoaded", () => {
    /* Form Select */
    // let choices = document.querySelectorAll(".choices");
    // let initChoice;
    // for (let i = 0; i < choices.length; i++) {
    //     if (choices[i].classList.contains("multiple-remove")) {
    //         initChoice = new Choices(choices[i], {
    //             delimiter: ",",
    //             editItems: true,
    //             maxItemCount: -1,
    //             removeItemButton: true,
    //         });
    //     } else {
    //         initChoice = new Choices(choices[i]);
    //     }
    // }

    /* Simple DataTable */
    /*
    let dataTable = new simpleDatatables.DataTable(document.getElementById("table1"));
    // Move "per page dropdown" selector element out of label
    // to make it work with bootstrap 5. Add bs5 classes.
    function adaptPageDropdown() {
      const selector = dataTable.wrapper.querySelector(".dataTable-selector");
      selector.parentNode.parentNode.insertBefore(selector, selector.parentNode);
      selector.classList.add("form-select");
    }

    // Add bs5 classes to pagination elements
    function adaptPagination() {
      const paginations = dataTable.wrapper.querySelectorAll(
        "ul.dataTable-pagination-list"
      );

      for (const pagination of paginations) {
        pagination.classList.add(...["pagination", "pagination-primary"]);
      }

      const paginationLis = dataTable.wrapper.querySelectorAll(
        "ul.dataTable-pagination-list li"
      );

      for (const paginationLi of paginationLis) {
        paginationLi.classList.add("page-item");
      }

      const paginationLinks = dataTable.wrapper.querySelectorAll(
        "ul.dataTable-pagination-list li a"
      );

      for (const paginationLink of paginationLinks) {
        paginationLink.classList.add("page-link");
      }
    }

    // Patch "per page dropdown" and pagination after table rendered
    dataTable.on("datatable.init", function () {
        adaptPageDropdown();
        adaptPagination();
    });

    // Re-patch pagination after the page was changed
    dataTable.on("datatable.page", adaptPagination);

    */


// });
