<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:23:35
         compiled from "C:\ecjia-daojia-29\content\apps\staff\templates\merchant\library\widget_merchant_dashboard_bar_chart.lbi.php" */ ?>
<?php /*%%SmartyHeaderCode:3081359084207e71dc8-25081050%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a4e33c87ce77b688bdb8d3d92dc893df9053eafa' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\staff\\templates\\merchant\\library\\widget_merchant_dashboard_bar_chart.lbi.php',
      1 => 1487583420,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3081359084207e71dc8-25081050',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order_arr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_59084207e90607_22009733',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59084207e90607_22009733')) {function content_59084207e90607_22009733($_smarty_tpl) {?><div class="row state-overview">
	<div class="col-lg-12 order_bar_chart">
		<div class="border-head m_t5">
			<h3>订单走势图</h3>
		</div>
		<div class="move-mod-group chart-mod1" id="widget_admin_dashboard_orderChart">
			<canvas id="order-chart"></canvas>
			<style type="text/css">
				.order_bar_chart{
					min-height:440px;
				}
				.chart-mod1 {
					padding: 0px;
					border-radius: 10px;
					margin-bottom: 0;
					box-sizing: border-box;
				}
				.chart-mod1 h3 {
					text-align: center;
					color: #fff;
					font-weight: normal;
				}
				.chart-mod1 canvas {
					max-width: 100%;
					height: 300px;
				}
				#widget_admin_dashboard_orderChart {
					position: relative;
					width: 100%;
				}
			</style>
			<script type="text/javascript">
			
				$(function(){
					var ctx = document.getElementById('order-chart').getContext("2d"),
		    
		                data = {
		                    labels : [<?php echo $_smarty_tpl->tpl_vars['order_arr']->value['day'];?>
],
		                    datasets : [{
		                        fillColor: "#BFC2CD",//填充色
		                        strokeColor: "#BFC2CD",//边框色
		                        data: [<?php echo $_smarty_tpl->tpl_vars['order_arr']->value['count'];?>
]
		                    }]
		                },
		    
						options = {
							//刻度线
							scaleLineColor : "#C9CDD7",
		
							//左侧刻度线是否显示
							scaleShowLabels : true,
							
							//刻度标签
							scaleLabel : "<<?php ?>%=value%<?php ?>>单",
							
							//底部刻度文字
							scaleFontColor : "#333",	
							
							//刻度显示网格线
							scaleShowGridLines : false,
							
							//柱状条的宽度
							barStrokeWidth : 1,
							
							//柱状条间距
							barValueSpacing : 2,
		
							//响应式
							responsive : true,
							
		// 					tooltipEvents: ["touchstart", "touchmove"],//"mousemove", 
		
							//是否有动画图表
							animation : true,
		
							//泡泡里字体
							tooltipFontSize : 10,
							//标题文字
							// tooltipTitleFontSize : 12,
							tooltipTitleFontStyle: "normal",
							//填充各地提示文本像素宽度
							// tooltipYPadding : 3,
							// tooltipXPadding : 3,
		
							//大小的提示插入符
							tooltipCaretSize : 4,
		
							//像素的工具提示边界半径
							tooltipCornerRadius : 4,
		
							//从像素点X偏移工具提示边缘
							// tooltipXOffset : 100, 
							// tooltipYOffset : 100, 
							tooltipTemplate : "<<?php ?>%= value %<?php ?>>", //"<<?php ?>%if (label){%<?php ?>><<?php ?>%=label%<?php ?>>: <<?php ?>%}%<?php ?>><<?php ?>%= value %<?php ?>>",
		
							//动画速度
							animationSteps : 50,
							
							//动画效果
							animationEasing : "easeOutQuart",//easeOutQuart、easeOutQuart
							
							legendTemplate : "<ul class=\"<<?php ?>%=name.toLowerCase()%<?php ?>>-legend\"><<?php ?>% for (var i=0; i<datasets.length; i++){%<?php ?>><li><span style=\"background-color:<<?php ?>%=datasets[i].fillColor%<?php ?>>\"></span><<?php ?>%if(datasets[i].label){%<?php ?>><<?php ?>%=datasets[i].label%<?php ?>><<?php ?>%}%<?php ?>></li><<?php ?>%}%<?php ?>></ul>"
						}
		
					var charts = new Chart(ctx).Bar(data,options);
								
					$('#order-chart').parents('.move-mod').find('.move-mod-group').on('mouseup', function(e) {
						charts.update();
					});
				})
			
			</script>
		</div>
	</div>
</div><?php }} ?>
