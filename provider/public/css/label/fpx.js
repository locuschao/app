var Fpx = Fpx || {};

(function(window, undefined) {
	Fpx.Print = function(settings) {
		this.data = settings.data;
		this.userName = settings.userName;
		this.identity = settings.identity;
		this.ctxPath = settings.ctxPath;
	};
	
	Fpx.Print.prototype = {
		constructor: Fpx.Print,
		data: null,
		userName: null,
		identity: null,
		ctxPath: null,
		init: function() {
			this.bindEvent();
			// 判断如果是IE8以下
			if(!$.support.leadingWhitespace) {
				$('.fpx-label-clear-c').hide();
				$('.fpx-label-page-break-c').hide();
			}
		},
		bindEvent: function() {
			$('input[name="printType"]').change(function(e) {
				var _this = $(this);
				var value = _this.val();
				if(value == "a4") {
					$('.fpx-label-label').addClass('fpx-label-a4').removeClass('fpx-label-label');
				} else {
					$('.fpx-label-a4').addClass('fpx-label-label').removeClass('fpx-label-a4');
				}
			});
			
			$('input[name="printContent"]').change(function(e) {
				var _this = $(this),
				value = _this.val();
				if(value == 'peihuo') {
					if(_this.attr('checked') == 'checked') {
						$('.fpx-label-peihuo').show();
					} else {
						$('.fpx-label-peihuo').hide();
					}
				} else if(value == 'buyerId') {
					if(_this.attr('checked') == 'checked') {
						$('.fpx-label-buyerid').show();
					} else {
						$('.fpx-label-buyerid').hide();
					}
				} else if(value == 'printTime') {
					if(_this.attr('checked') == 'checked') {
						$('.fpx-label-print-time').show();
					} else {
						$('.fpx-label-print-time').hide();
					}
				} else if(value == 'printPeihuoBarcode') {
					if(_this.attr('checked') == 'checked') {
						$('.fpx-peihuolist-barcode').addClass('fpx-peihuolist-barcode-show');
						$('.fpx-peihuolist-barcode-state').addClass('fpx-peihuolist-barcode-state-show');
					} else {
						$('.fpx-peihuolist-barcode').removeClass('fpx-peihuolist-barcode-show');
						$('.fpx-peihuolist-barcode-state').removeClass('fpx-peihuolist-barcode-state-show');
					}
				} else {
					$('.fpx-declaration-weight-val').each(function(e) {
						var $this = $(this);
						var cWeight = $this.attr('data-customerWeight');
						if(_this.attr('checked') == 'checked') {
							if(cWeight == null || $.trim(cWeight).length == 0) {
								$this.html('0.2');
							} else {
								$this.html(cWeight);
							}
						} else {
							$this.html('0.2');
						}
					});
				}
			});
			
			$('input[name="printSelect"]').change(function(e) {
				var _this = $(this),
				value = _this.val();
				if(value == 'peihuo') {
					if(_this.attr('checked') == 'checked') {
//						$('.fpx-peihuolist-container').show();
						$('.fpx-peihuolist-container').addClass('fpx-peihuolist-container-show');
					} else {
						$('.fpx-peihuolist-container').removeClass('fpx-peihuolist-container-show');
//						$('.fpx-peihuolist-container').hide();
					}
				} else if(value == 'declaration') {
					if(_this.attr('checked') == 'checked') {
//						$('.fpx-declaration-container').show();
						$('.fpx-declaration-container').addClass('fpx-declaration-container-show');
						$('.fpx-declaration-container-blank').removeClass('fpx-declaration-container-show');
					} else {
//						$('.fpx-declaration-container').hide();
						$('.fpx-declaration-container').removeClass('fpx-declaration-container-show');
					}
				}
				var checkedLen = $('input[name="printSelect"]:checked').length;
				if(checkedLen == 1) {
					$('.fpx-order-container').addClass('fpx-order-container-two-content');
					$('.fpx-order-container-two').addClass('fpx-order-container-two-content-page');
					
					$('.fpx-order-container').removeClass('fpx-order-container-three-content-page');
					$('.fpx-order-container').removeClass('fpx-order-container-one-content-page');
				} else if(checkedLen == 2) {
					$('.fpx-order-container').removeClass('fpx-order-container-two-content');
					$('.fpx-order-container-three').addClass('fpx-order-container-three-content-page');
					
					$('.fpx-order-container').removeClass('fpx-order-container-one-content-page');
					$('.fpx-order-container').removeClass('fpx-order-container-two-content-page');
				} else {
					$('.fpx-order-container').removeClass('fpx-order-container-two-content');
					$('.fpx-order-container-one').addClass('fpx-order-container-one-content-page');
					
					$('.fpx-order-container').removeClass('fpx-order-container-three-content-page');
					$('.fpx-order-container').removeClass('fpx-order-container-two-content-page');
				}
			});
			
			//选择邮件货物类型事件
			$('.fpx-label-content').on('click', '.fpx-declaration-category-input', function(e) {
				var $this = $(this);
				var className = $this.attr('data-class');
				$('.' + className).removeAttr('checked');
				if($this.hasClass('checked-x')) {
//					$('.' + className).show();
					$('.' + className).next('label').find('.input-img-checked').removeClass('checked-img');
					$('.' + className).next('label').find('.input-img-unchecked').addClass('input-img');
					$this.next('label').find('.input-img-unchecked').removeClass('input-img');
					$this.next('label').find('.input-img-checked').addClass('checked-img');
//					$this.hide();
				}
				$this.attr('checked', 'checked');
			});
			
			var _this = this;
			// 显示高级选项事件
			$('.fpx-label-print-advanced-a').on('click', function(e) {
				var $this = $(this);
				if($this.html() == '收起') {
					$this.html('高级选项');
					$this.next('img').attr('src', _this.ctxPath + '/imgs/down.png');
					$('.fpx-label-print-a').hide();
				} else {
					$this.html('收起');
					$this.next('img').attr('src', _this.ctxPath + '/imgs/up.png');
					$('.fpx-label-print-a').show();
				}
			});
			
			// 生成图片事件
			$('.fpx-label-print-a').on('click', 'a', function(e) {
				var data = _this.data;
				var $target = $(e.target);
				var prompt = $('.fpx-label-prompt');
				prompt.html('正在生成图片...');
				var url = _this.ctxPath + '/print/labelImgHtml.do';
				if($target.hasClass('fpx-label-pdf-print-a')) {
					url = _this.ctxPath + '/print/pdfPrint.do';
					prompt.html('正在生成pdf...');
				}
				prompt.show();
				// 打印类型
				var labelType = $('input[name="printType"]:checked').val();
				// 打印选项
				var isDeclarationList = 'N';
				var isPeihuoList = 'N';
				$('input[name="printSelect"]:checked').each(function(e) {
					var $this = $(this);
					if($this.val() == 'declaration') {
						isDeclarationList = 'Y';
					} else if($this.val() == 'peihuo') {
						isPeihuoList = 'Y';
					}
				});
				// 打印内容
				var isPrintTime = 'N';
				var isPrintBuyerId = 'N';
				var isPeihuoInfo = 'N';
				var isCustomerWeight = 'N';
				var isPeihuoBarcode = 'N';
				$('input[name="printContent"]:checked').each(function(e) {
					var $this = $(this);
					if($this.val() == 'peihuo') {
						isPeihuoInfo = 'Y';
					} else if($this.val() == 'buyerId') {
						isPrintBuyerId = 'Y';
					} else if($this.val() == 'printTime') {
						isPrintTime = 'Y';
					} else if($this.val() == 'printPeihuoBarcode') {
						isPeihuoBarcode = 'Y';
					} else if($this.val() == 'customerWeight') {
						isCustomerWeight = 'Y';
					}
				});
				data["labelType"] = labelType;
				data["isDeclarationList"] = isDeclarationList;
				data["isPeihuoList"] = isPeihuoList;
				data["isPrintTime"] = isPrintTime;
				data["isPrintBuyerId"] = isPrintBuyerId;
				data["isPeihuoInfo"] = isPeihuoInfo;
				data["isCustomerWeight"] = isCustomerWeight;
				data["isPeihuoBarcode"] = isPeihuoBarcode;
				var param = {};
				param["data"] = JSON.stringify(data);
				param["userName"] = _this.userName;
				var identity = _this.identity;
				param["encipherment"] = b64_md5(identity + param["data"]);
				
				$.ajax({
					url: url,
					data: param,
					type: 'POST',
					success: function(result) {
						if(result.status == 1) {
							prompt.hide();
//							console.log(result.htmlUrl);
							if($target.hasClass('fpx-label-pdf-print-a')) {
//								location.href = result.pdfUrl;
								window.open(result.pdfUrl);
							} else {
//								location.href = result.htmlUrl;
								window.open(result.htmlUrl);
							}
						} else {
							prompt.html('操作失败，请稍后重试!');
						}
					}
				});
				return false;
			});
			
		}
	};
}(window));