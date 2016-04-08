$(function () {
    var base_url = window.location.pathname;
    $(document).on('change', '.featuredform', function (e) {
        e.preventDefault();
        var ID = $(this).attr('rel');
        var Value = $(this).is(":checked");

        $.ajax({
            url: 'post/setfeatured',
            type: 'POST',
            data: {id: ID, value: Value}
        });
    });
    $(document).on('change', '.publishedform', function (e) {
        e.preventDefault();
        var ID = $(this).attr('rel');
        var Value = $(this).is(":checked");

        $.ajax({
            url: 'faq/setpublished',
            type: 'POST',
            data: {id: ID, value: Value}
        });
    });

    $('.priceType').each(function (index) {
        var Id = $(this).attr('rel');
        var CurrentValue = $("#price-" + Id).val();
        if (parseInt(CurrentValue) >= 0) {
            $("#price-" + Id).attr({
                type: 'text',
                value: CurrentValue
            });
        } else {
            $("#price-" + Id).attr({
                type: 'hidden',
                value: CurrentValue
            });
        }
    });

    $(document).on('change', '.priceType', function (e) {
        var Id = $(this).attr('rel');
        var Value = $(this).val();
        if (Value === '-3') {
            $("#price-" + Id).attr({
                type: 'text',
                value: 0
            });
        } else {
            $("#price-" + Id).attr({
                type: 'hidden',
                value: parseInt(Value)
            });
        }
        $.ajax({
            url: 'country/edit',
            type: 'POST',
            data: {name: 'price', value: $("#price-" + Id).val(), id: Id}
        });
    });

    $(document).on('change', '.country_js', function (e) {
        var Name = $(this).attr('name');
        var Id = $(this).attr('rel');
        var Value = $(this).val();
        if (Name === 'published') {
            if ($(this).is(":checked")) {
                Value = 1;
            } else {
                Value = 0;
            }
        }
        $.ajax({
            url: 'country/edit',
            type: 'POST',
            data: {name: Name, value: Value, id: Id}
        });
    });

    $(document).on('change', '.region_js', function (e) {
        e.preventDefault();
        var Id = $(this).attr('rel');
        var Value = $(this).val();
        $.ajax({
            url: 'region/edit',
            type: 'POST',
            data: {id: Id, value: Value}
        });
    });

    $(document).on('change', '.values_js', function (e) {
        e.preventDefault();
        var Key = $(this).attr('name');
        var Value = $(this).val();
        $.ajax({
            url: 'sysvalues/edit',
            type: 'POST',
            data: {key: Key, value: Value}
        });
    });

    $(document).on('click', '#postdate', function (e) {
        e.preventDefault();
        plotPosts();
    });
    function plotPosts() {
        posts = $('#postsg');
        posts.hide();
        $('#postsg > .loading').show();
        $.ajax({
            dataType: "json",
            url: 'post/plot',
            data: {'from': $('#fromposts').val(), 'to': $('#topost').val()},
            success: function (data) {
                poltLines(posts, data.points);
                $('#postsg > .loading').hide();
                posts.html(data.total);
                posts.fadeIn();
            }
        });
    }
    $(document).on('click', '#userdate', function (e) {
        e.preventDefault();
        plotUser();
    });
    function plotUser() {
        users = $('#usersg');
        users.hide();
        $('#usersg > .loading').show();
        $.ajax({
            dataType: "json",
            url: 'user/plot',
            data: {'from': $('#fromuser').val(), 'to': $('#touser').val()},
            success: function (data) {
                poltLines(users, data.points);
                $('#usersg > .loading').hide();
                users.html(data.total);
                users.fadeIn();
            }
        });
    }
    var plot
    function poltLines(view, data) {
        plot = $.plot(view,
                [{data: data,
                        color: "#c75d7b"}],
                {
                    series: {
                        lines: {
                            show: true,
                            fill: true,
                            fillColor: "rgba(255, 204, 204, 0.7)"
                        },
                        points: {
                            show: false
                        }
                    },
                    xaxis: {
                        mode: "time",
                        timeformat: "%m/%d"
                    },
                    yaxis: {min: 0},
                    tooltip: true,
                    grid: {
                        hoverable: true,
                        clickable: false,
                        borderWidth: 0
                    },
                });
    }
    if (base_url === '/') {
        plotUser();
        plotPosts();
    }

    bulkmailv($('#emailqueue-type').val());
    function bulkmailv(Id) {
        if (Id === '2') {
            $('#customEmail').show();
        } else {
            $('#customEmail').hide();
        }
        if (Id === '1') {
            $('#NewsLetter').show();
        } else {
            $('#NewsLetter').hide();
        }
    }
    $('#emailqueue-type').change(function () {
        bulkmailv($(this).val());
    });

    $('#previewEmail').change(function () {
        $.ajax({
            url: 'preview',
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {
                $('#prev-content').html(data);
            }
        });
    });
});