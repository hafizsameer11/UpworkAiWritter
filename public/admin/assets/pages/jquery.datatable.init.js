$(document).ready(function () {

            // Format function for child row (details)
            function format(d) {
                return `
                <table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
                    <tr><td>ID:</td><td>${d.id}</td></tr>
                    <tr><td>Slug:</td><td>${d.slug}</td></tr>
                    <tr><td>Created:</td><td>${d.created_at}</td></tr>
                    <tr><td>Updated:</td><td>${d.updated_at}</td></tr>
                </table>
            `;
            }

            // Fetch the data and initialize DataTable after response
            $.ajax({
                url: '/api/niches', // Update this if your route is different
                method: 'GET',
                success: function (response) {
                    const table = $('#child_rows').DataTable({
                        data: response,
                        columns: [
                            {
                                className: 'details-control',
                                orderable: false,
                                data: null,
                                defaultContent: ''
                            },
                            { data: 'name', title: 'Name' },
                            { data: 'description', title: 'Description' },
                            { data: 'slug', title: 'Slug' }
                        ],
                        order: [[1, 'asc']]
                    });

                    // Toggle child row
                    $('#child_rows tbody').on('click', 'td.details-control', function () {
                        var tr = $(this).closest('tr');
                        var row = table.row(tr);

                        if (row.child.isShown()) {
                            row.child.hide();
                            tr.removeClass('shown');
                        } else {
                            row.child(format(row.data())).show();
                            tr.addClass('shown');
                        }
                    });
                },
                error: function (xhr) {
                    console.error('AJAX GET Error:', xhr.responseText);
                }
            });
        });