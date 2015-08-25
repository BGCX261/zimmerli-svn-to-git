// устанавливает обработчики событий на элемент(ы) для проверки валидации телефонного номера
function fieldPhone(e){
	// обработчики событий: когда пользователь отпускает, нажимает клавишу клавиатуры и когда поле теряет фокус (keyup keypress change)
	$(e).bind('keyup change', function(event){
		phoneValid(this, event, true);
	});
}
// проверка валидации номера телефона введенного в заданное поле
function phoneValid(e, event_, endfocus){

	if(typeof(e.value)!="string" || event_.ctrlKey // Ctrl
		|| event_.keyCode=="13" // Enter
		|| event_.keyCode=="37" // вверх
		|| event_.keyCode=="38" // вправо
		|| event_.keyCode=="39" // вниз
		|| event_.keyCode=="40" // влево
		|| event_.keyCode=="8"// tab
		|| event_.keyCode=="16"){// Shift
		return false;
	}
	var numberFocusPos = getFocusPos(e);// получаем номер позиции фокуса
	var numberFocusPosSet = 0;// реальная позиция фокуса после трансформации числа
	var numberFocusPosI = 0;// номер символа в for
	var numberFocusPosRealNumber = 0;// реальный номер символа

	var str = e.value;// введенный пользователем номер
	var newstr = "";// исправленный номер
	var number_badge = 0;// цифровая позиция цифры номера
	var symbol = "";// переменная под символ
	var clear_number = "";// номер исключительно из цифр (без всяких других знаков)

	if(str.substr(0,1)==" "){
		str = str.substr(1,100);
	}// удаление пробела в самом начале // нуля в самом начале ИЛИ str.substr(0,1)=="0" ||
	if(str.substr(str.length,1)==" "){
		str = str.substr(0,(str.length-1));
	}// удаление пробела в самом конце

	for(var i=0; i<str.length; i++){

		symbol = str.substr(i,1);

		if(symbol!=" " && isNaN(symbol)==false){// если цифра

			//~alert("i="+i+" | symbol="+symbol);

			clear_number += symbol;

			numberFocusPosI += 1;

		}

		if((i+1)==numberFocusPos && !numberFocusPosRealNumber){
			numberFocusPosRealNumber = numberFocusPosI;
		}
	}
	//~alert(numberFocusPos+"=="+numberFocusPosRealNumber);
	// если в начале номера знак +, при этом следующая цифра не задана или являеся цифрой 7 или 3 (правильно записываемый номер или Украина)
	if(str.substr(0,1)=="+"){
		newstr = "+"+newstr;
	}// && (str.substr(1,1)=="" || str.substr(1,1)=="7" || str.substr(1,1)=="3")

	for(var i=0; i<clear_number.length; i++){

		symbol = clear_number.substr(i,1);

		newstr += symbol;

		if((str.substr(0,1)=="8" || str.substr(0,2)=="+7") && clear_number.length<12){// исправление номеров с 8 или +7

			if(i==0){
				newstr += " (";
			}
			if(i==3){
				newstr += ") ";
			}
			if(i==6){
				newstr += "-";
			}

		}else if(clear_number.substr(0,6)=="810380"){// исправление украинских номеров вида: 810380626743377 на 8-10-380 (6267) 43-377

			if(i==0 || i==2 || i==12){
				newstr += "-";
			}// тире
			if(i==9){
				newstr += ")";
			} // скобка )
			if(i==5 || i==9){
				newstr += " ";
			}// пробелы
			if(i==5){
				newstr += "(";
			} // скобка (

		}else if(clear_number.substr(0,3)=="380"){// исправление украинских номеров вида: +380930595377 на +380 (93) 059-5377

			if(i==7){
				newstr += "-";
			}// тире
			if(i==4){
				newstr += ")";
			} // скобка )
			if(i==2 || i==4){
				newstr += " ";
			} // пробелы
			if(i==2){
				newstr += "(";
			} // скобка (

		}else if(clear_number.substr(0,1)=="9" && clear_number.length=="10"){// исправление российских номеров вида: 9264215497 на +7 (926) 421-5497

			if(i==0){
				newstr = "+7 (9";
			}// тире
			if(i==2){
				newstr += ") ";
			} // скобка ) с пробелом
			if(i==5){
				newstr += "-";
			}// тире

		}else if(clear_number.substr(0,1)=="7" && clear_number.length=="11"){// исправление российских номеров вида: 74957887706 на +7 (495) 788-7706

			if(i==0){
				newstr = "+7 (";
			}// тире
			if(i==3){
				newstr += ") ";
			} // скобка ) с пробелом
			if(i==6){
				newstr += "-";
			}// тире

		}else{// неизвестный вид номера разделяем промежуточными тире
			if(i==2 || (i==5 && clear_number.length>7) || i==9 || i==13 || i==17){
				newstr += "-";
			}//
		}
		//~alert(numberFocusPosRealNumber+"=="+i+"--"+newstr+"=="+newstr.length);
		if((i+1) == numberFocusPosRealNumber && !numberFocusPosSet){
			//~alert(i+"=="+numberFocusPosRealNumber+"--"+newstr+"=="+newstr.length);
			numberFocusPosSet = newstr.length;
		}
	}
	// если фокус покидает поле, и на конце сформировавшегося номера знак - тире
	if(endfocus && newstr.substr((newstr.length-1),1)=="-"){
		newstr = newstr.substr(0,(newstr.length-1));
	}

	e.value = newstr;

	if(numberFocusPosRealNumber==0 && str.substr(0,1)=="+"){
		numberFocusPosSet += 1;
	}// выставление фокуса после ввода знака +

	if(numberFocusPosSet){
		setFocusPos(e, numberFocusPosSet);
	}//~alert("numberFocusPosSet="+numberFocusPosSet);

	return false;
}
// получает позицию фокуса (курсора) в заданном поле
function getFocusPos(e){
	var pos = 0;
	if($.browser.msie){
		var r = e.document.selection.createRange();
		r.moveStart('textedit', -1);
		pos = r.text.length;

	}else{
		pos = e.selectionEnd;// находим порядковый номер окончания выделения
	}
	return pos;
}
// устанавливает позицию фокуса (курсора) в заданном поле
function setFocusPos(e, pos){
	if($.browser.msie){
		var r = e.createTextRange();// создаем на основе выделенного объект TextRange
		r.collapse(true);
		r.moveEnd('character', pos);// начальная позиция равна длинне нового текста
		r.moveStart('character', pos);//конечная позиция равна минусовой длинне вставляемого текста
		r.select();
	}else{
		e.setSelectionRange(pos,pos);
	}
}