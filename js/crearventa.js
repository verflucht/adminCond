$(document).ready(function() {   
    var sideslider = $('[data-toggle=collapse-side]');
    var sel = sideslider.attr('data-target');
    var sel2 = sideslider.attr('data-target-2');
    sideslider.click(function(event){
        $(sel).toggleClass('in');
        $(sel2).toggleClass('out');
    });
});

$(function (){
    var isVendido = 0;
      $.ajax({
      type: "POST",
      url: "loadVentas.php",
      data: {isVendido:isVendido},
      cache: false,
      success: function(result){
        $('#ventas').html('');
        $('#ventas').html(result);
      },
        error: function(result){
        alert(result);
      }
    });
});

$(function(){
        
    var values = new Array();
    
    $(document).on('change', '.form-group-multiple-selects .input-group-multiple-select:last-child select', function(){
        
        var selectsLength = $('.form-group-multiple-selects .input-group-multiple-select select').length;
        var optionsLength = ($(this).find('option').length)-1;

        
        if(selectsLength < optionsLength){
            var sInputGroupHtml = $(this).parent().html();
            var sInputGroupClasses = $(this).parent().attr('class');
            $(this).parent().parent().append('<div class="'+sInputGroupClasses+'">'+sInputGroupHtml+'</div>');  
        }
        
        updateValues();
        
    });
    
    $(document).on('change', '.form-group-multiple-selects .input-group-multiple-select:not(:last-child) select', function(){
        
        updateValues();
        
    });
    
    $(document).on('click', '.input-group-addon-remove', function(){
        $(this).parent().remove();
        updateValues();
    });
    
    function updateValues()
    {
        values = new Array();
        $('.form-group-multiple-selects .input-group-multiple-select select').each(function(){
            var value = $(this).val();
            if(value != 0 && value != ""){
                values.push(value);
            }
        });
        
        $('.form-group-multiple-selects .input-group-multiple-select select').find('option').each(function(){
            var optionValue = $(this).val();
            var selectValue = $(this).parent().val();
            if(in_array(optionValue,values)!= -1 && selectValue != optionValue)
            {
                $(this).attr('disabled', 'disabled');
            }
            else
            {
                $(this).removeAttr('disabled');
            }
        });
    }
    
    function in_array(needle, haystack){
        var found = 0;
        for (var i=0, length=haystack.length;i<length;i++) {
            if (haystack[i] == needle) return i;
            found++;
        }
        return -1;
    }
});

$(function() {
$('body').on('click', 'a.btn-cancelar-venta',function() {
    var id = this.id
    if (window.confirm("¿Estas seguro que deseas eliminar la venta?")){
      $.ajax({
      type: "POST",
      url: "cancelarventa.php",
      data: {id:id},
      cache: false,
      success: function(result){
        if (result == ''){
          window.location.reload();
        }
        else{
          alert(result);
        }
      }
    });
    }
});
});

$(function() {
$('body').on('click', 'a.btn-vender', function() {
    var id = this.id
    if (window.confirm("¿Estas seguro finalizar la venta?")){
      $.ajax({
      type: "POST",
      url: "finalizarventa.php",
      data: {id:id},
      cache: false,
      success: function(result){
        if (result == ''){
          window.location.reload();
          // alert(result);
        }
        else{
          alert(result);
        }
      }
    });
    }
});
});

$(function(){
  $('body').on('click', 'li.btn-ventas' ,function() {
      var isVendido = this.id
      $.ajax({
        type: "POST",
        url: "loadVentas.php",
        data: {isVendido:isVendido},
        cache: false,
        success: function(result){
          // alert(result);
          $('#ventas').html('');
          $('#ventas').html(result);
        },
        error: function(result){
          alert(result);
        }
      });
  });
});

$(function(){
  $('body').on('click', 'input.btn-crearventa', function () {
    var imprimir = "imprimir";
    $.ajax({
      type: "GET",
      url: "formulario.php",
      data: $('#formulario').serialize(),
      cache: false,
      success: function(result){
        //alert(result);
        location.reload();
      },
      error: function(result){
          alert("ERROR: "+result);
      }
    });
  });
});

$(function(){
  $('body').on('click', '.btn-loadeditar', function () {
    var id = this.id;
    $.ajax({
      type: "GET",
      url: "loadmodaleditar.php",
      data: {id:id},
      cache: false,
      success: function(result){
        // alert(result);
        $('.modal-editarventa').html("");
        $('.modal-editarventa').html(result);
        $('#modalEditarVenta').modal('show');
      },
      error: function(result){
          alert("ERROR: "+result);
      }
    });
  });
});

$(function () {
  $(".form_datetime").datetimepicker({
    format: 'yyyy-mm-dd hh:ii:ss',
    autoclose: true,
    todayBtn: true
  });
});