$(".slider").owlCarousel({
    margin: 20,
    loop: true,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 1,
            nav: false
        },
        600: {
            items: 2,
            nav: false
        },
        1000: {
            items: 3,
            nav: false
        }
    }
});

$('.brand-carousel').owlCarousel({
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 2000,
    responsive: {
        0: {
            items: 3
        },

        600: {
            items: 4
        },
        1000: {
            items: 5
        }
    }
});

$('#click').on('click', function () {
    console.log($(this).val())
    Swal.fire({
        title: 'Masukkan kode pemilihan',
        input: 'text'
    }).then(function (text) {
        console.log(text.value)
        console.log('oke')
        if (text.value) {
            $.ajax({
                type: "POST",
                url: "/e-vote/user/validate",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    candidate_id: $('#candidate_id').val(),
                    reg_id: text.value,
                },
                success: function (data) {

                    console.log(data);
                    if (data == 0) {
                        Swal.fire({
                            title: 'Kode Yang Dimasukkan Salah',
                            icon: 'warning'
                        })
                    } else if (data == 1) {
                        Swal.fire({
                            title: 'Anda Sudah Memilih',
                            icon: 'info'
                        })
                    } else if (data == 3) {
                        Swal.fire({
                            title: 'Poling Belum dimulai',
                            icon: 'warning'
                        })
                    } else if (data == 4) {
                        Swal.fire({
                            title: 'Poling Sudah Selesai',
                            icon: 'warning'
                        })
                    } else if (data == 2) {
                        Swal.fire({
                            title: 'Voting anda telah masuk',
                            icon: 'success'
                        })
                    } else {
                        Swal.fire({
                            title: 'Kode Salah',
                            icon: 'warning'
                        })
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Anda belum masukan kode");
                }
            })
        } else {
            Swal.fire({
                title: 'Data masih kosong',
                icon: 'warning'
            })
        }

    })
});

$(document).ready(function () {
    $('select').selectize({
        sortField: 'text'
    });
});

//Reference:
//https://www.onextrapixel.com/2012/12/10/how-to-create-a-custom-file-input-with-jquery-css3-and-php/
;
(function ($) {

    // Browser supports HTML5 multiple file?
    var multipleSupport = typeof $('<input/>')[0].multiple !== 'undefined',
        isIE = /msie/i.test(navigator.userAgent);

    $.fn.customFile = function () {

        return this.each(function () {

            var $file = $(this).addClass('custom-file-upload-hidden'), // the original file input
                $wrap = $('<div class="file-upload-wrapper">'),
                $input = $('<input type="text" class="file-upload-input" />'),
                // Button that will be used in non-IE browsers
                $button = $('<button type="button" class="file-upload-button">Select a File</button>'),
                // Hack for IE
                $label = $('<label class="file-upload-button" for="' + $file[0].id + '">Select a File</label>');

            // Hide by shifting to the left so we
            // can still trigger events
            $file.css({
                position: 'absolute',
                left: '-9999px'
            });

            $wrap.insertAfter($file)
                .append($file, $input, (isIE ? $label : $button));

            // Prevent focus
            $file.attr('tabIndex', -1);
            $button.attr('tabIndex', -1);

            $button.click(function () {
                $file.focus().click(); // Open dialog
            });

            $file.change(function () {

                var files = [],
                    fileArr, filename;

                // If multiple is supported then extract
                // all filenames from the file array
                if (multipleSupport) {
                    fileArr = $file[0].files;
                    for (var i = 0, len = fileArr.length; i < len; i++) {
                        files.push(fileArr[i].name);
                    }
                    filename = files.join(', ');

                    // If not supported then just take the value
                    // and remove the path to just show the filename
                } else {
                    filename = $file.val().split('\\').pop();
                }

                $input.val(filename) // Set the value
                    .attr('title', filename) // Show filename in title tootlip
                    .focus(); // Regain focus

            });

            $input.on({
                blur: function () {
                    $file.trigger('blur');
                },
                keydown: function (e) {
                    if (e.which === 13) { // Enter
                        if (!isIE) {
                            $file.trigger('click');
                        }
                    } else if (e.which === 8 || e.which === 46) { // Backspace & Del
                        // On some browsers the value is read-only
                        // with this trick we remove the old input and add
                        // a clean clone with all the original events attached
                        $file.replaceWith($file = $file.clone(true));
                        $file.trigger('change');
                        $input.val('');
                    } else if (e.which === 9) { // TAB
                        return;
                    } else { // All other keys
                        return false;
                    }
                }
            });

        });

    };

    // Old browser fallback
    if (!multipleSupport) {
        $(document).on('change', 'input.customfile', function () {

            var $this = $(this),
                // Create a unique ID so we
                // can attach the label to the input
                uniqId = 'customfile_' + (new Date()).getTime(),
                $wrap = $this.parent(),

                // Filter empty input
                $inputs = $wrap.siblings().find('.file-upload-input')
                .filter(function () {
                    return !this.value
                }),

                $file = $('<input type="file" id="' + uniqId + '" name="' + $this.attr('name') + '"/>');

            // 1ms timeout so it runs after all other events
            // that modify the value have triggered
            setTimeout(function () {
                // Add a new input
                if ($this.val()) {
                    // Check for empty fields to prevent
                    // creating new inputs when changing files
                    if (!$inputs.length) {
                        $wrap.after($file);
                        $file.customFile();
                    }
                    // Remove and reorganize inputs
                } else {
                    $inputs.parent().remove();
                    // Move the input so it's always last on the list
                    $wrap.appendTo($wrap.parent());
                    $wrap.find('input').focus();
                }
            }, 1);

        });
    }

}(jQuery));

$('input[type=file]').customFile();

function previewImage() {
    document.getElementById("image-preview").style.display = "block";
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("image-source").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("image-preview").src = oFREvent.target.result;
    };
};


