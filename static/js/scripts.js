(function ($) {
    "use strict";
    $(document).ready(function () {
        /*==Left Navigation Accordion ==*/
		
		setTimeout(function(){$('#autoClose').click()},"5000");
        if ($.fn.dcAccordion) {
            $('#nav-accordion').dcAccordion({
                eventType: 'click',
                autoClose: true,
                saveState: true,
                disableLink: true,
                speed: 'slow',
                showCount: false,
                autoExpand: true,
                classExpand: 'dcjq-current-parent'
            });
        }
        /*==Slim Scroll ==*/
        if ($.fn.slimScroll) {
            $('.event-list').slimscroll({
                height: '305px',
                wheelStep: 20
            });
            $('.conversation-list').slimscroll({
                height: '360px',
                wheelStep: 35
            });
            $('.to-do-list').slimscroll({
                height: '300px',
                wheelStep: 35
            });
        }
        /*==Nice Scroll ==*/
        if ($.fn.niceScroll) {


            $(".leftside-navigation").niceScroll({
                cursorcolor: "#1FB5AD",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "3px"
            });

            $(".leftside-navigation").getNiceScroll().resize();
            if ($('#sidebar').hasClass('hide-left-bar')) {
                $(".leftside-navigation").getNiceScroll().hide();
            }
            $(".leftside-navigation").getNiceScroll().show();

            $(".right-stat-bar").niceScroll({
                cursorcolor: "#1FB5AD",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "3px"
            });

        }

        /*==Easy Pie chart ==*/
        if ($.fn.easyPieChart) {

            $('.notification-pie-chart').easyPieChart({
                onStep: function (from, to, percent) {
                    $(this.el).find('.percent').text(Math.round(percent));
                },
                barColor: "#39b6ac",
                lineWidth: 3,
                size: 50,
                trackColor: "#efefef",
                scaleColor: "#cccccc"

            });

            $('.pc-epie-chart').easyPieChart({
                onStep: function(from, to, percent) {
                    $(this.el).find('.percent').text(Math.round(percent));
                },
                barColor: "#5bc6f0",
                lineWidth: 3,
                size:50,
                trackColor: "#32323a",
                scaleColor:"#cccccc"

            });

        }

        /*== SPARKLINE==*/
        if ($.fn.sparkline) {

            $(".d-pending").sparkline([3, 1], {
                type: 'pie',
                width: '40',
                height: '40',
                sliceColors: ['#e1e1e1', '#8175c9']
            });



            var sparkLine = function () {
                $(".sparkline").each(function () {
                    var $data = $(this).data();
                    ($data.type == 'pie') && $data.sliceColors && ($data.sliceColors = eval($data.sliceColors));
                    ($data.type == 'bar') && $data.stackedBarColor && ($data.stackedBarColor = eval($data.stackedBarColor));

                    $data.valueSpots = {
                        '0:': $data.spotColor
                    };
                    $(this).sparkline($data.data || "html", $data);


                    if ($(this).data("compositeData")) {
                        $spdata.composite = true;
                        $spdata.minSpotColor = false;
                        $spdata.maxSpotColor = false;
                        $spdata.valueSpots = {
                            '0:': $spdata.spotColor
                        };
                        $(this).sparkline($(this).data("compositeData"), $spdata);
                    };
                });
            };

            var sparkResize;
            $(window).resize(function (e) {
                clearTimeout(sparkResize);
                sparkResize = setTimeout(function () {
                    sparkLine(true)
                }, 500);
            });
            sparkLine(false);



        }



        if ($.fn.plot) {
            var datatPie = [30, 50];
            // DONUT
            $.plot($(".target-sell"), datatPie, {
                series: {
                    pie: {
                        innerRadius: 0.6,
                        show: true,
                        label: {
                            show: false

                        },
                        stroke: {
                            width: .01,
                            color: '#fff'

                        }
                    }




                },

                legend: {
                    show: true
                },
                grid: {
                    hoverable: true,
                    clickable: true
                },

                colors: ["#ff6d60", "#cbcdd9"]
            });
        }



        /*==Collapsible==*/
        $('.widget-head').click(function (e) {
            var widgetElem = $(this).children('.widget-collapse').children('i');

            $(this)
                .next('.widget-container')
                .slideToggle('slow');
            if ($(widgetElem).hasClass('ico-minus')) {
                $(widgetElem).removeClass('ico-minus');
                $(widgetElem).addClass('ico-plus');
            } else {
                $(widgetElem).removeClass('ico-plus');
                $(widgetElem).addClass('ico-minus');
            }
            e.preventDefault();
        });




        /*==Sidebar Toggle==

        $(".leftside-navigation .sub-menu > a").click(function () {
            var o = ($(this).offset());
            var diff = 80 - o.top;
            if (diff > 0)
                $(".leftside-navigation").scrollTo("-=" + Math.abs(diff), 500);
            else
                $(".leftside-navigation").scrollTo("+=" + Math.abs(diff), 500);
        });
*/


        $('.sidebar-toggle-box .fa-bars').click(function (e) {

            $(".leftside-navigation").niceScroll({
                cursorcolor: "#1FB5AD",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "3px"
            });

            $('#sidebar').toggleClass('hide-left-bar');
            if ($('#sidebar').hasClass('hide-left-bar')) {
                $(".leftside-navigation").getNiceScroll().hide();
            }
            $(".leftside-navigation").getNiceScroll().show();
            $('#main-content').toggleClass('merge-left');
            e.stopPropagation();
            if ($('#container').hasClass('open-right-panel')) {
                $('#container').removeClass('open-right-panel')
            }
            if ($('.right-sidebar').hasClass('open-right-bar')) {
                $('.right-sidebar').removeClass('open-right-bar')
            }

            if ($('.header').hasClass('merge-header')) {
                $('.header').removeClass('merge-header')
            }


        });
        $('.toggle-right-box .fa-bars').click(function (e) {
            $('#container').toggleClass('open-right-panel');
            $('.right-sidebar').toggleClass('open-right-bar');
            $('.header').toggleClass('merge-header');

            e.stopPropagation();
        });

        $('.header,#main-content,#sidebar').click(function () {
            if ($('#container').hasClass('open-right-panel')) {
                $('#container').removeClass('open-right-panel')
            }
            if ($('.right-sidebar').hasClass('open-right-bar')) {
                $('.right-sidebar').removeClass('open-right-bar')
            }

            if ($('.header').hasClass('merge-header')) {
                $('.header').removeClass('merge-header')
            }


        });


        $('.panel .tools .fa').click(function () {
            var el = $(this).parents(".panel").children(".panel-body");
            if ($(this).hasClass("fa-chevron-down")) {
                $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
                el.slideUp(200);
            } else {
                $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
                el.slideDown(200); }
        });



        $('.panel .tools .fa-times').click(function () {
            $(this).parents(".panel").parent().remove();
        });

        // tool tips

        $('.tooltips').tooltip();

        // popovers

        $('.popovers').popover();
    });

})(jQuery);

function load_ajax_datatable(idTable,Url,sortColumn,sortType)
{	
	sortColumn = typeof sortColumn !== 'undefined' ? sortColumn : 0;
	sortType = typeof sortType !== 'undefined' ? sortType : 'desc';
	$('#'+idTable).dataTable
	({
		"iDisplayLength" : 10, //jumlah default data yang ditampilkan
		"aLengthMenu" : [5,10,25,50,100], //isi combo box menampilkan jumlah data
		"aaSorting" : [[sortColumn, sortType]], //index kolom yg akan di-sorting
		"bProcessing" : true, //show tulisan dan loading bar
		'bServerSide' : true, //ajax server side
		'sAjaxSource' : Url, //url ajax nya
		"sServerMethod" : "POST",
		'fnServerData' : function(sSource, aoData, fnCallback)
						{
							$.ajax
							({
								'dataType': 'json',
								'type' : 'POST',
								'url' : sSource,
								'data' : aoData,
								'success' : function(json){
										fnCallback(json);
										$(".pop_over").popover();
								}
							});
						},
	}); 
}

// modif fungsi sebelumnya
function load_ajax_datatable2(idTable,Url,columnsDef,sortColumn,sortType,dataProp)
{
	/* "scrollY": 200,
       */
	sortColumn = typeof sortColumn !== 'undefined' ? sortColumn : 0;
	sortType = typeof sortType !== 'undefined' ? sortType : 'desc';
	dataProp = typeof dataProp !== 'undefined' ? dataProp : 'data';
	$('#'+idTable).dataTable
	({
		"iDisplayStart ": 0,
		"iDisplayLength" : 10, //jumlah default data yang ditampilkan
		"aLengthMenu" : [5,10,25,50,100], //isi combo box menampilkan jumlah data
		"aaSorting" : [[sortColumn, sortType]], //index kolom yg akan di-sorting
		"bProcessing" : true, //show tulisan dan loading bar
		'bServerSide' : true, //ajax server side
		'sAjaxSource' : Url, //url ajax nya
		"sAjaxDataProp": dataProp,
		"sServerMethod" : "POST",
		"bDestroy": true,
		 "aoColumns":columnsDef,
		"bJQueryUI":true,	
		"scrollX": true	,
		"sDom": 'rt<"top"lpi>',	//mengatur posisi toolbar  cek http://legacy.datatables.net/usage/options#sDom
		 
		'fnServerData' : function(sSource, aoData, fnCallback)
						{
							$.ajax
							({
								'dataType': 'json',
								'type' : 'POST',
								'url' : sSource,
								'data' : aoData,
								'success' : function(json){
										fnCallback(json);
										$(".pop_over").popover();
								}
							});
						}
	}); 
}