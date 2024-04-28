let tanggal = new Date().getDate()
let bulan = new Date().getMonth() + 1
let tahun = new Date().getFullYear()

const date = `${tanggal}-${bulan}-${tahun}`

$(document).ready(function() {
  $('#dataTable').DataTable({
    oLanguage: {
      "sSearch": "Cari Buku: "
    },
    select: true,
    dom: 'Bfrtip',
    lengthMenu: [
      [ 10, 25, 50, -1 ],
      [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    ],
        buttons: [
          {
            extend: 'print',
            text: 'Print',
            title: `ArseneLib Report (${tanggal}-${bulan}-${tahun}) `,
            className: 'btn btn-sm btn-primary',
            exportOptions: {
              columns: 'th:not(:last-child)'
            },
          },
          {
            extend: 'excel',
            text: 'Excel',
            title: `ArseneLib Report (${tanggal}-${bulan}-${tahun}) `,
            className: 'btn btn-sm btn-success',
            exportOptions: {
              columns: 'th:not(:last-child)'
            },
          },
          {
            extend: 'pdf',
            text: 'PDF',
            title: `ArseneLib Report (${tanggal}-${bulan}-${tahun}) `,
            className: 'btn btn-sm btn-danger',
            exportOptions: {
              columns: 'th:not(:last-child)'
            },
            customize: function (doc) {
              doc.content[1].table.widths = 
                  Array(doc.content[1].table.body[0].length + 1).join('*').split('');
            }
          },
          {
            extend: 'pageLength',
            className: 'btn btn-sm btn-secondary',
          }
        ],
  });
});

$(document).ready(function () {
  $('#dataTable2').DataTable({
    oLanguage: {
      "sSearch": "Cari Item: ",
      "sEmptyTable": "Tidak ada history. Anda belum meminjam buku"
    },
  });
});

$(document).ready(function () {
  $('#dataTable3').DataTable({
    oLanguage: {
      "sSearch": "Cari Item: ",
      "sEmptyTable": "Tidak ada history. Anda belum meminjam buku"
    },
  });
});