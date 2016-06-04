$(function () {
	function udateAward() {
		var total = 0;

		$('.award .amount input').each(function () {
			var $this = $(this);
			var value = Math.max(0, $this.val() * 1);
			$("#" + $this.data('conversion')).html(value * exchangeRate);
			total += value;
		});
	}
	$(".award .amount input").on('change keyup', function () {
		udateAward();
	});
	udateAward();
});
