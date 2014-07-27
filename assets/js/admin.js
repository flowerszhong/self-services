$(function () {


var GLOBAL_SEARCH_PARAM = null;

var $studentsList = $("#students-list"),
	$searchBtn = $('#search-btn');

  $('#search-btn').on('click',loadData);

  function getParam () {
  	var $recordLimitSelect = $('#row-limit'),
  		$studentId = $("#student_id"),
        $studentName = $("#student_name"),
  		$email = $('#user-email');

  		var param = {
  			'doSearch': 'Search',
  			'record_limit' : $recordLimitSelect.val(),
  			'student_id' : $studentId.val(),
  			'user_email' : $email.val(),
  		}
  		return param;
  }


  function getManyParams () {

    var $recordLimitSelect = $('#row-limit'),
        $grade = $("#grade"),
        $department = $("#department"),
        $major = $("#major"),
        $subMajor = $("#sub-major"),
        $classes = $('#class-list');


    var param ={
        'grade' : $grade.val(),
        'department': $department.val(),
        'major' : $major.val(),
        'sub_major' : $subMajor.val(),
        'class' : $classes.val(),
        'page_limit': $recordLimitSelect.val()
    }

    return param;

  }

  function getOneParams () {
    var $recordLimitSelect = $('#row-limit'),
        $user_email = $('#user_email'),
        $student_id = $("#student_id"),
        $user_name = $("#user_name");

    return {
      'student_id' : $student_id.val(),
      'user_email' : $user_email.val(),
      'user_name' : $user_name.val(),
      'page_limit' : $recordLimitSelect.val()
    }
  }



  $("#row-limit").change(function () {
    GLOBAL_SEARCH_PARAM['page_limit'] = this.value;
    GLOBAL_SEARCH_PARAM['pn'] = 1;
    loadData();
  });

  $studentsList.on('click','.associate-btn',function () {
    var relid = $(this).attr('relid');
    var $this = $(this);
    $.get("do.php",{
      cmd:"associate",
      id : relid
    },function (data) {
      // console.log(data);
    })
  });


  $("#doAllocation").click(function () {
    var ids = getCheckAllRowsId();
    if(ids.length){
      $.get("do.php",{
        cmd:"associate",
        id : ids
      },function () {
        // $this.text("ok");
      })
    }

  });

  function getCheckAllRowsId () {
    var $checkedRecords = $studentsList.find(".record-check:checked");
    var ids = [];
    for (var i = 0; i < $checkedRecords.length; i++) {
      ids.push($checkedRecords[i].value);
    };

    return ids.join(',');
  }


  $("#checkall").on('click',function () {
    $studentsList.find(".record-check").prop("checked",true);
  });

  $("#uncheckall").on('click',function () {
    $studentsList.find(".record-check").prop("checked",false);
  });


  


  $("#btn-search-many").click(function () {
    GLOBAL_SEARCH_PARAM = getManyParams();
    loadData();
  });

  $("#btn-search-one").click(function () {
    GLOBAL_SEARCH_PARAM = getOneParams();
    loadData();
  });


  function loadData () {
    $studentsList.prepend("<tr class='loading'><td colspan='11'>Loading...</td></tr>");

    $.ajax({
          type: "POST",
          url: "search.php",
          data: GLOBAL_SEARCH_PARAM,
          success: function  (data) {
            if(data && data.state =="ok"){
              showSearchResult(data);
            }
          },
          dataType: "json"
        });
  }



  $("#page-controls").on("click","a",function (e) {
    e.preventDefault();
    var hash = this.href.split('#')[1];
    GLOBAL_SEARCH_PARAM['pn'] = hash;
    loadData();
  });



  function showSearchResult (data) {

    $studentsList.remove(".loading");
    $("#page-controls").empty().append(data.controls);
    $("#page-state").empty().append(data.pageState);

    var markup = ["<tr>",
          "<td>${id}</td>",
          "<td>${student_id}</td>",
          "<td>${user_name}</td>",
          "<td>${user_email}</td>",
          "<td>${grade}</td>",
          "<td>${department}</td>",
          "<td>${major}</td>",
          "<td>${sub_major}</td>",
          "<td>${$item.getClass()}</td>",
          "<td>${approved}</td>",
          "<td>${approved}</td>",
          "</tr>"].join('');

    /* Compile the markup as a named template */
    $.template( "studentTMPL", markup );

    /* Render the template with the movies data and insert
       the rendered HTML under the "movieList" element */
    $studentsList.empty().append($.tmpl( "studentTMPL", data.rows,{
      getClass : function (data) {
        return this.data['class'] + "班";
      }
    }));

  }





});






































