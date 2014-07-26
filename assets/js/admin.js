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
        dataType: "json"
    }

    return param;

  }

  function loadData () {
  	$searchBtn.prop('disabled','true');
  	$studentsList.prepend("<tr class='loading'><td colspan='11'>Loading...</td></tr>");
  	var param = getParam();
  	
  }

  $("#row-limit,#grade").change(loadData);

  $studentsList.on('click','.associate-btn',function () {
    var relid = $(this).attr('relid');
    var $this = $(this);
    $.get("do.php",{
      cmd:"associate",
      id : relid
    },function (data) {
      console.log(data);
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

    console.log(GLOBAL_SEARCH_PARAM);

    // $.post("search.php",GLOBAL_SEARCH_PARAM,function (data) {
    //     console.log(typeof data)
    //     console.log(data);
    // });


    $.ajax({
          type: "POST",
          url: "search.php",
          data: GLOBAL_SEARCH_PARAM,
          success: function  (data) {
              console.log(data);
          },
          dataType: "json"
        });
  });





});






































