<?php
	echo $this->Form->create('Animal' , ['type'=>'post','url'=>['action'=>'reg']] );
	echo $this->Form->text('animal_name');
	echo $this->Form->submit('送信');
	echo $this->Form->end();
	?>
