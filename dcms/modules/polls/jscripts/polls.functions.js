(function(D) {
	D.register('polls', new function() {
		var me = this;
		
		me.questions_list = new Array();
		me.current_question = 0;
		// answered questions count
		me.questions_completed = 0;
		// total count of questions
		me.questions_total = 0;
		me.saves_pool = {};
		// when user opened this question
		me.questions_start_time = {};
		
		me.on_question_open   = false;
		me.on_question_opened = false;
		me.on_question_next   = false;
		me.on_question_prev   = false;
		
		this.start_poll = function() {
			// first we need to bind needed buttons
			$('.polls_show_poll_toggle_descr').click(function(){
				var descr_body = $('.polls_show_poll_descr_body');
				if( descr_body.is(':visible')) {
					descr_body.hide();
					$(this).html('Показать');
				} else {
					descr_body.show();
					$(this).html('Скрыть');
				}
			});
			
			// now lets collect list of all questions
			$('.polls_single_question').each(function() {
				var question = this;
				var mode = $(this).attr('data-mode');
				me.questions_total++;
				me.questions_list.push($(this).attr('data-qid'));
				
				// bind selectors
				$(question).find('.polls_answer_select SPAN').click(function(){
					//alert("test");
					if(mode == 1 ) {
						$(question).find('.polls_answer_select > SPAN').removeClass('active');
						$(this).toggleClass('active');
					} else {
						if ( mode == 3 ) {
							$(question).find('[data-answer="own"]').removeClass('active');
							$(question).find('[name="own_answer"]').attr('disabled', true);
						}
						
						$(this).toggleClass('active');
					}
					if( $(this).attr('data-answer') == 'own') {
						$(question).find('[name="own_answer"]').attr('disabled', false);
						$(question).find('.polls_answer_select > SPAN').removeClass('active');
						$(this).addClass('active');
					}
				});
			});
			
			$('.polls_go_next').click(function(){
				me.go_next_question();
				return false;
			});
			$('.polls_show_poll_prev A').click(function(){
				me.go_prev_question();
			});
			// initialize all elements
			me.show_question(me.questions_list[0]);
		};

		this.question_error = function(error) {
			if( error == '') {
				$('.polls_error_message').hide();
			} else {
				$('.polls_error_message').html(error).show();
			}
		};
		
		this.check_answers = function(qid) {
			var question = $('.polls_single_question[data-qid="' + qid + '"]');
			var mode = parseInt(question.attr('data-mode'));
			var checked_count = 0;
			var own_answer = question.find('[name=own_answer]').val();
			if( mode == 1 || mode == 2 || mode == 3 || mode == 4 ) {
				question.find('.polls_answer_select SPAN').each(function() {
					if( $(this).hasClass('active')) {
						checked_count++;
					}
				});
			}
			if( mode == 0 ) {
				if( question.find('[name=own_answer]').val() == '' ) {
					me.question_error("Вы не указали свой ответ!");
					return false;
				}
			} else if ( mode == 1 ) {
				if( checked_count == 0 ) {
					me.question_error("Необходимо указать ответ!");
					return false;
				}
			} else if ( mode == 2 ) {
				if( checked_count == 0 ) {
					me.question_error("Вы не указали ни одного варианта!");
					return false;
				}

			} else if ( mode == 3 ) {
				if ( checked_count == 0 ) {
					me.question_error("Вы не выбрали ни одного варианта!");
					return false;
				}
			} else if ( mode == 4 ) {
				if ( checked_count == 0 && own_answer == '') {
					me.question_error("Вы не выбрали ни одного варианта!");
					return false;
				}
			}
			question.find('.polls_answer_select SPAN').each(function(){
			});
			me.question_error('');
			return true;
		};
		
		this.save_answer = function(qid) {
			var question = $('.polls_single_question[data-qid="' + qid + '"]');
			var mode = parseInt($(question).attr('data-mode'));
			// now lets create answers list and other stuff
			// select only one answer
			var answers_list = '';
			var own_answer = question.find('[name=own_answer]').val();
			
			if( mode == 1) {
				question.find('.polls_answer_select SPAN').each(function(){
					if($(this).hasClass('active')) {
						answers_list = $(this).attr('data-answer');
					}
				});
			} else if (mode == 2 || mode == 3 || mode == 4 ) {
				var answers = new Array();
				question.find('.polls_answer_select SPAN').each(function(){
					if($(this).hasClass('active')) {
						answers.push($(this).attr('data-answer'));
					}
				});
				answers_list = answers.join(',');
			}
			me.saves_pool[qid] = 'wait';
			
			var think_time = ( new Date().getTime() - me.questions_start_time[qid] ) / 1000;

			
			me.run('submit-question-answer', {'answers_list' : answers_list, 'think_time': think_time, 'own_answer': own_answer, 'qid' : qid}, function(answer) {
				if(answer.status == 'OK') {
					me.saves_pool[qid] = 'done';
				}
			});
		};

		// load data from JSON
		this.load_results = function(data) {
			var last_qid = 0;
			var count = 0;
			for(var i in data) {
				if ( typeof data[i] == 'object' ) {
					me.load_question_data(data[i]);
					last_qid = data[i].qid;
					count++;
				}
			}
			me.show_question(last_qid);
			me.go_next_question();
		};
		
		this.load_progress = function(data) {
			return false;
		};

		this.load_question_data = function(data) {
			var question = $('.polls_single_question[data-qid="' + data.qid + '"]');
			var mode = question.attr('data-mode');
			if ( mode == 0 || mode == 3 || mode == 4 ) {
				question.find('[name=own_answer]').val(data.own_answer);
			}
			if( mode == '1' ) {
				question.find('SPAN[data-answer="' + data.answers_list + '"]').addClass('active');
			}
			if( mode == '2' || mode == '3' || mode == '4' ) {
				var answers = data.answers_list.split(',');
				for(var num in answers) {
					if( typeof answers[num] == 'string') {
						question.find('SPAN[data-answer="' + answers[num] + '"]').addClass('active');
					}
				}
			}
		};
		
		
		this.go_next_question = function() {
			if( !me.check_answers(me.current_question)) {
				return false;
			}
			me.save_answer(me.current_question);
			var next_qid_num = me.questions_list.indexOf(me.current_question) + 1;
				
			if(next_qid_num >= me.questions_total ) {
				me.show_poll_finish();
			} else {
				var qid = me.questions_list[next_qid_num];
				if( typeof me.on_question_next == 'function' ) {
					me.on_question_next(qid);
				}
				me.show_question(qid);
			}
		};
		
		this.go_prev_question = function() {
			var prev_qid_num = me.questions_list.indexOf(me.current_question) - 1;
			if( typeof me.on_question_prev == 'function' ) {
				me.on_question_prev(me.questions_list[prev_qid_num]);
			}
			me.show_question(me.questions_list[prev_qid_num]);
		};
		
		
		this.show_poll_finish = function() {
			$('.polls_questions_list').hide();
			$('.polls_show_poll_controls').hide();
			$('.polls_final_message').show();
		};
		
		
		this.show_question = function(qid) {
			if(qid == me.questions_list[0]) {
				$('.polls_show_poll_prev A').hide();
			} else {
				$('.polls_show_poll_prev A').show();
			}
			if(qid == me.questions_list[me.questions_list.length - 1]) {
				$('.polls_show_poll_next A').html('Завершить');
				$('.polls_go_next_poll_button BUTTON').html('Завершить');
			} else {
				$('.polls_show_poll_next A').html('Следующий вопрос');
				$('.polls_go_next_poll_button BUTTON').html('Дальше');
			}
			if( typeof me.on_question_open  == 'function' ) {
				me.on_question_open(qid);
			}
			me.questions_start_time[qid] = new Date().getTime();
			$('.polls_single_question[data-qid="' + me.current_question + '"]').hide();
			var new_question = $('.polls_single_question[data-qid="' + qid + '"]');
			var completed_count = new_question.attr('data-num');
			$('.polls_show_poll_completed_questions').html(completed_count);
			$('.polls_show_poll_completed_questions_prc').html( Math.round( 100 * ( completed_count - 1)/ me.questions_total) + '%');
			new_question.show();
			me.current_question = qid;
			if ( typeof me.on_question_opened  == 'function' ) {
				me.on_question_opened(qid);
			}
		};
	});
})(D);