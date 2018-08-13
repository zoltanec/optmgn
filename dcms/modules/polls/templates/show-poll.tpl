<script type="text/javascript">
var category_worker = new function() {
	var me = this;
	me.trigger_questions = new Array();

	this.add_trigger_qid = function(qid) {
		me.trigger_questions.push(qid);
	};

	this.on_question_prev = function(qid) {
		$('.polls_go_next').show();
	};

	this.on_question_next = function(qid) {
		var pos = me.trigger_questions.indexOf(qid);
		if( pos != -1 ) {
			var question = $('DIV[data-qid="' + qid + '"]');
			if ( question.find('.polls_category_start_block').length == 0 ) {
				return true;
			}
			$('.polls_go_next').hide();
			question.find('.polls_question_body').hide();
			question.find('.polls_go_to_polls_list_button').click(function() {
				question.find('.polls_category_start_block').remove();
				question.find('.polls_question_body').show();
				$('.polls_go_next').show();
				VK.callMethod('resizeWindow',607, $('BODY').height() + 90 );
			});
		}
	};
};
</script>
<a class="polls_back_to_all" href="<{$me.path}>/">Назад ко всем анкетам</a>
<div class="polls_show_poll_header"><{$poll->name}></div>
<div class="polls_show_poll_descr_head">
	<span>Описание</span>
	<a class="polls_show_poll_toggle_descr" href="#">Скрыть</a>
</div>
<div class="polls_show_poll_descr_body"><{$poll->descr}></div>


<div class="polls_show_poll_controls">
	<div class="polls_show_poll_prev"><a href="#">Предыдущий вопрос</a>&nbsp;</div>
	<div class="polls_show_poll_status"><span class="polls_show_poll_completed_questions">1</span> из <{sizeof($poll->active_questions)}>
	<b>( <span class="polls_show_poll_completed_questions_prc">0 %</span> )</b> </div>
	<div class="polls_show_poll_next">&nbsp;<a class="polls_go_next" href="#">Следующий вопрос</a></div>
</div>

<div class="polls_questions_list">
	<div class="polls_error_message"></div>
	<{assign var=last_catid value=0}>
	<{foreach item=question from=$poll->active_questions}>
	<div style="display: none;" class="polls_single_question polls_question_mode_<{$question->mode}>" data-qid="<{$question->qid}>" data-num="<{$question->num}>" data-mode="<{$question->mode}>">

		<{if $question->catid != 0}>
			<{assign var=cat value=$poll->getCategoryInfo($question->catid)}>
			<{if $last_catid != $question->catid}>
<script type="text/javascript">
category_worker.add_trigger_qid('<{$question->qid}>');
</script>
			<{/if}>
			<div class="polls_category_header">
				<{$cat->name}>
			</div>
			<div class="polls_category_start_block">
				<{if $last_catid != $question->catid}>

				<div class="polls_category_start_descr"><{$cat->descr|clean}></div>
				<div class="polls_category_start_button">
					<div class="polls_go_to_polls_list_button polls_category_start_button"><button>Перейти к вопросам</button></div>
				</div>
				<{/if}>
			</div>
		<{/if}>

		<div class="polls_question_body">
			<div class="polls_question_self"><b>Вопрос:</b><{$question->question}></div>
			<div class="polls_question_help"><{$question->help}></div>
			<div class="polls_question_mode">
				<{if $question->mode > 0}>
					<{if $question->mode == 1}>
					Выберите один из вариантов ответа:
					<{else}>
					Выберите один или несколько вариантов ответа:
					<{/if}>
				<{/if}>
				</div>
			<div class="polls_question_variants_select">
				<ul>
				<{foreach item=variant key=num from=$question->getAnswers()}>
					<li class="polls_answer_select"><span data-answer="<{$num}>"></span><{$variant}></li>
				<{/foreach}>
				<{if $question->mode == 0 || $question->mode == 3 || $question->mode == 4}>
					<li class="polls_answer_select">
					<div class="polls_question_enter_own_answer">

				 	<b><{if $question->mode == 3}><span data-answer="own"></span><{/if}>Укажите свой вариант ответа:</b>
					<textarea class="polls_enter_own_answer" name="own_answer"></textarea>
					</div>
					</li>
				<{/if}>
				</ul>
			</div>
		</div>
	<{assign var=last_catid value=$question->catid}>
	</div>
	<{/foreach}>
	<div class="polls_go_next_poll_button polls_go_next"><button>Дальше</button></div>
</div>

<div class="polls_final_message" style="display:none;">
<img src="<{$theme.images}>/completed.jpg"><br>
<{$poll->final_message}>
<div class="polls_go_to_polls_list_button"><button onclick="document.location.href='<{$me.path}>/index/';">Вернутся к списку анкет</button></div>
</div>

<script type="text/javascript">
D.modules.polls.on_question_next = category_worker.on_question_next;
D.modules.polls.on_question_prev = category_worker.on_question_prev;

D.modules.polls.on_question_opened = function(qid) {
	VK.callMethod('resizeWindow',607, $('BODY').height() + 90 );
};
D.modules.polls.start_poll();
<{if $req->param2 != 'restart'}>
D.modules.polls.load_results(<{json_encode(Polls_Useranswer::getUserAnswersForQids($poll->qids, $user->uid))}>);
<{else}>
D.modules.polls.load_results([]);
<{/if}>
</script>
