$(function() {

  var GLOBAL_SEARCH_PARAM = null;

  $(".statistics-table").on('click', "a", function(e) {
    var $link = $(this);
    var num = parseInt($link.text());
    if (num > 0) {
      var begin_date = $link.parent().parent().attr("data-id");
      var account_type = $link.attr("data-type");
      var page_limit = $('#row-limit').val();

      GLOBAL_SEARCH_PARAM = {
        'begin_date': begin_date,
        'account_type': account_type,
        'page_limit': parseInt(page_limit),
        'account_num': num
      }

      loadData();

    }
    e.preventDefault();
  });

  var $accountsList = $("#accounts-list"),
    $searchBtn = $('#search-btn');

  $("#row-limit").change(function() {
    GLOBAL_SEARCH_PARAM['page_limit'] = this.value;
    GLOBAL_SEARCH_PARAM['pn'] = 1;
    loadData();
  });

  function loadData() {
    $accountsList.prepend("<tr class='loading'><td colspan='11'>Loading...</td></tr>");

    $.ajax({
      type: "GET",
      url: "details.php",
      data: GLOBAL_SEARCH_PARAM,
      success: function(data) {
        if (data && data.state == "ok") {
          showSearchResult(data);
        }
      },
      dataType: "json"
    });
  }

  $("#page-controls").on("click", "a", function(e) {
    e.preventDefault();
    var hash = this.href.split('#')[1];
    GLOBAL_SEARCH_PARAM['pn'] = hash;
    loadData();
  });



  function showSearchResult(data) {

    $accountsList.remove(".loading");
    $("#page-controls").empty().append(data.controls);
    $("#page-state").empty().append(data.pageState);

    var markup = ["<tr>",
      "<td><input type='checkbox' value='${id}' class='record-check' /></td>",
      "<td>${net_id}</td>",
      "<td>${net_pwd}</td>",
      "<td>${student_id}</td>",
      "<td>${start_date}</td>",
      "<td>${end_date}</td>",
      "<td>${available}</td>",
      // "<td>${$item.getClass()}</td>",
      // "<td>${$item.checkAssoicate()}</td>",
      "</tr>"
    ].join('');

    /* Compile the markup as a named template */
    $.template("accountTMPL", markup);

    /* Render the template with the movies data and insert
       the rendered HTML under the "movieList" element */
    $accountsList.empty().append($.tmpl("accountTMPL", data.rows, {
      getClass: function(data) {
        return this.data['class'] + "班";
      },
      checkAssoicate: function() {
        if (this.data['net_id'] && this.data['net_pwd']) {
          return "是";
        } else {
          return "否";
        }
      }
    }));

  }

});