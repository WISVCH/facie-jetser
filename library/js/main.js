$(document).ready(function () {

  /**
   * Standard hides
   */
  $("#fotoScreen").hide();
  $("#listOfMentoren").hide();
  $("#spellNullen").hide();
  $("#spellMentoren").hide();

  
  $("#submitMentorStukje").hide();
  $(".saving-image").hide();

  $("#mode").val("saving");
  $("#type").val("nul");

  $('marquee').marquee();

  /**
   *  Navigationbar on the right side
   */
  $("#listOfNullen").height( $(window).height() - 102 );
  $("#listOfMentoren").height( $(window).height() - 102 );
  $("#spellMentoren").height( $(window).height() - 102);
  $("#spellNullen").height( $(window).height() - 102);
  $(".saving-image").css("left", (( $(window).width() / 4 ) - 86));
  $("#searchMentor").width( ($(window).width() / 2) - 70 );
  $("#searchNul").width( ($(window).width() / 2) - 70 );
  $("#searchSpellMentor").width( ($(window).width() / 2) - 70 );
  $("#searchSpellNul").width( ($(window).width() / 2) - 70 );

  /**
   * Counting the chars in textfield
   */
  $("#stukje").keyup(function() { 
    var charSet = $("#stukje").val().length;
    $(".stukjeCharaters .number").text(charSet);
  });

  /**
   * Changes the picture when photonumber changes
   */
  $("#fotoNummer").blur(function() {
    $("#foto").attr("src", "library/pics/DSC0" + $("#fotoNummer").val() + ".JPG");
    $("#fotoScreen").height( $(window).height() - 102 );

    $(".nav-tab-item").each(function() {
      $(this).removeClass("active");
    })
    $("#nav-fotoScreen").addClass("active");

    $(".screens").each(function() {
      $(this).hide();
    })
    $("#fotoScreen").show();
  });

  /**
   * Switching tabs
   */
  $(".nav-pills li").click(function() {
    $(".nav-pills li").each(function() {
      $(this).removeClass("active");
    })
    $(this).addClass("active");

    $(".screens").each(function() {
      $(this).hide();
    })
    $("#" + $(this).attr('id').split("-")[1]).show();

    if (typeof $(this).data("mode") != 'undefined') {
      $("#mode").val($(this).data("mode"));
      $("#type").val($(this).data("type"));
    }
  })
  
  /**
   *  Searchfield commands
   */
  $("#searchMentor").keyup(function() {
    loadApi("facie_export_mentoren", $("#searchMentor").val(), "#contentOfMentoren", false);  
  });
  $("#searchNul").keyup(function() {
    loadApi("facie_export_nullen", $("#searchNul").val(), "#contentOfNullen", false);  
  });
  $("#searchSpellNul").keyup(function() {
    loadApi("facie_data_nullen", $("#searchSpellNul").val(), "#contentOfSpellNullen", true);  
  });
  $("#searchSpellMentor").keyup(function() {
    loadApi("facie_data_mentoren", $("#searchSpellMentor").val(), "#contentOfSpellMentoren", true);  
  });



  /**
   *  Save the data for a Nul 
   */
  $("#submitStukje").click(function() {
    $("#image-saving").fadeIn(200);
    $(".has-error").removeClass(".has-error");

    $.ajax({
      type: "POST",
      url: "library/scripts/saving.php",
      data: { 
        naam: $("#naam").val(), 
        email: $("#email").val(),
        woonplaats: $("#woonplaats").val(),
        mobiel: $("#mobiel").val(),
        datum: $("#datum").val(),
        studie: $("#studie").val(),
        id: $("#id").val(),
        fotoNummer: $("#fotoNummer").val(),
        stukje: $("#stukje").val(),
        writter: $("#writter").val(),
        mode: $("#mode").val(),
        type: $("#type").val()
      }
    }).done(function(item) {
      $("#image-saving").hide();
      if (item == "NOT SAVED") {
        $("#error-message").text("NIET OPGESLAGEN");
        $("#image-error").show().delay(2000).fadeOut(200);
      } else if (item.match("EmptyInputExteption:")) {
        var missingInput = item.split(":")[1];
        $("#error-message").text("Missing input");
        $("#image-error").show().delay(2000).fadeOut(200);

        $("#" + missingInput).parent().addClass("has-error");
      } else if (item == "Illegal access" || item == "EmptyStringExpetion") {
        $("#error-message").text(item);
        $("#image-error").show().delay(2000).fadeOut(200);
      } else if (item == "Success") {
        $("#image-done").show().delay(1000).fadeOut(200);

        $("input.delete").val("");
        $(".form-group textarea").val("");

        loadApi("facie_export_nullen", "", "#contentOfNullen", false);
        loadApi("facie_data_nullen", "", "#contentOfSpellNullen", true);
        loadApi("facie_export_mentoren", "", "#contentOfMentoren", false);
        loadApi("facie_data_mentoren", "", "#contentOfSpellMentoren", true);
      } else {
        $("#error-message").text("Unexpected error!");
        $("#image-error").show().delay(2000).fadeOut(200);
      }
    }).fail(function(item) {
      
    });
  });

  /**
   * Loading loadApi into content
   */
  function loadApi(table, query, content, written) {
    query = encodeURIComponent(query);
    query = query.replace("%20", "+");
    var url = 'library/scripts/api.php?table=' + table + "&written=" + written;
    if (query !== 'undefined') {
        url = 'library/scripts/api.php?table=' + table + "&written=" + written + "&query=" + query;
    }
    $.getJSON(url, function( json ) {
      var list = "";
      if (json.result[0]) {
        $.each(json.result, function(i, item) {
          var clazz = "";
          list += '<tr class="' + clazz + '" onClick="loadGegevens(\'' 
                        + addslashes(item.id) + "', '"
                        + addslashes(item.naam) + "', '"
                        + addslashes(item.email) + "', '"
                        + addslashes(item.woonplaats) + "', '"
                        + addslashes(item.telefoon) + "', '"
                        + addslashes(item.studie) + "', '"
                        + addslashes(item.datum) + "', '"
                        + addslashes(item.stukje) + "', '"
                        + addslashes(item.foto) +
                  '\')">';
            if (written == true) {
              if (!(item.naam) ||
                  !(item.email) ||
                  !(item.woonplaats) ||
                  !(item.telefoon) ||
                  !(item.studie) ||
                  !(item.datum) ||
                  !(item.stukje) ||
                  !(item.foto) || 
                  item.foto == "DSC0") {
                list += "<td class='danger'>&nsp;</td>";
              } else if (item.checked == "1") {
                list += "<td class='success'></td>";
              } else {
                list += "<td class='warning'></td>";
              } 
            } else {
              list += "<td style='background: #fff3e0;'></td>";
            }
            list += '<td>' + item.naam + '</td><td>' + item.email + '</td>';
          list += '</tr>';
        });

        $(content).html(list);
      } else {
        $(content).html('<tr><td colspan="2"><center>Geen zoekresultaten gevonden</center></td></tr>');
      }
    }).fail(function( jqxhr, textStatus, error ) {
      var err = textStatus + ", " + error;
      console.log( "Request Failed: " + err );
    });
  }

  function loadStats() {
    $.getJSON("library/scripts/getData.php", function( json ) {
      var stats = "<li>NULLEN: <span class='content'>" + json.result.total_nullen + "/" +json.result.togo_nullen + "</span></li><li>MENTOREN: <span class='content'>" + json.result.total_mentoren + "/" + json.result.togo_mentoren + "</span></li>";
      $.each(json.result.leden, function(i, item) {
       stats += "<li>" + item.naam + ": <span class'content'>" + item.aantal + "</span></li>";
      });
      $(".orange-info-bar .row .stats").html(stats);
    }).fail(function( jqxhr, textStatus, error ) {
      var err = textStatus + ", " + error;
      console.log( "Request Failed: " + err );
    });
  }

  /**
   * Loading content
   */
  loadApi("facie_export_nullen", "", "#contentOfNullen", false);
  loadApi("facie_data_nullen", "", "#contentOfSpellNullen", true);
  loadApi("facie_export_mentoren", "", "#contentOfMentoren", false);
  loadApi("facie_data_mentoren", "", "#contentOfSpellMentoren", true);
  loadStats();
  

  /**
   * If there is nothing in input #seachNul and the div listOfNullen is active then refreash the listOfNullen every 10 seconds
   * And it also reloads the stats every 10 seconds no matter what.
   */ 
  window.setInterval(function() { 
    loadStats();
  }, 300000);

});

function loadGegevens(id, naam, email, woonplaats, telefoon, studie, datum, stukje, foto) {
  (id !== 'undefined') ? $("#id").val(id) : $("#id").val("");
  (naam !== 'undefined') ? $("#naam").val(naam) : $("#naam").val("");
  (email !== 'undefined') ? $("#email").val(email) : $("#email").val("");
  (woonplaats !== 'undefined') ? $("#woonplaats").val(woonplaats) : $("#woonplaats").val("");
  (telefoon !== 'undefined') ? $("#mobiel").val(telefoon) : $("#mobiel").val("");
  (studie !== 'undefined') ? $("#studie").val(studie) : $("#studie").val("");
  (datum !== 'undefined') ? $("#datum").val(datum) : $("#datum").val("");
  (stukje !== 'undefined') ? $("#stukje").val(stukje) : $("#stukje").val("");
  (foto !== 'undefined') ? $("#fotoNummer").val(foto): $("#fotoNummer").val("");
}

function addslashes(str) {
  return (str + '')
    .replace(/[\\"']/g, '\\$&')
    .replace(/\u0000/g, '\\0')
    .replace("&#039;", "\\'");
}