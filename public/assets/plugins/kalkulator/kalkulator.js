var Calculator = {
    results_value: '0',
    memory_id: 'calculator-screen-and-result',
    memory_value: '',
    history_id: 'calc-history-list',
    history_value: [],
    last_result_used: false,

    SUM: ' + ',
    MIN: ' - ',
    DIV: ' / ',
    MULT: ' * ',
    PROC: '%',
    SIN: 'sin(',
    COS: 'cos(',
    MOD: ' mod ',
    BRO: '(',
    BRC: ')',

    calculate: function() {
        var memoryValueWithoutEquals = this.memory_value.replace('=', '');
        this.history_value.push(memoryValueWithoutEquals);
        this.results_value = this.engine.exec(memoryValueWithoutEquals);
        this.add_to_history();
        this.memory_value = this.results_value.toString();
        this.last_result_used = true;
        this.refresh();
    },

    put: function(value) {
        if (this.last_result_used) {
            this.last_result_used = false;
        }
        if (value !== '=') {
            this.memory_value += value;
            this.update_memory();
        }
    },

    reset: function() {
        this.memory_value = '';
        this.results_value = '0';
        this.clear_history();
        this.refresh();
        this.last_result_used = false;
    },

    delete_last: function() {
        if (this.memory_value.length > 0) {
            this.memory_value = this.memory_value.slice(0, -1);
            this.update_memory();
        }
    },

    refresh: function() {
        this.update_result();
        this.update_memory();
    },

    update_result: function() {
        document.getElementById(this.memory_id).value = this.results_value;
    },

    update_memory: function() {
        document.getElementById(this.memory_id).value = this.memory_value;
    },

    add_to_history: function() {
        if (!isNaN(this.results_value)) {
            var div = document.createElement('li');
            div.textContent = this.memory_value + ' = ' + this.results_value;

            var tag = document.getElementById(this.history_id);
            tag.insertBefore(div, tag.firstChild);
        }
    },

    clear_history: function() {
        $('#' + this.history_id + '> li').remove();
    },

    engine: {
        exec: function(value) {
            try {
                return eval(this.parse(value));
            } catch (e) {
                return e;
            }
        },

        parse: function(value) {
            if (value != null && value != '') {
                value = this.replaceFun(value, Calculator.PROC, '/100');
                value = this.replaceFun(value, Calculator.MOD, '%');
                value = this.addSequence(value, Calculator.PROC);
                return value;
            } else {
                return '0';
            }
        },

        replaceFun: function(txt, reg, fun) {
            return txt.replace(new RegExp(reg, 'g'), fun);
        },

        addSequence: function(txt, fun) {
            var list = txt.split(fun);
            var line = '';

            for (var nr in list) {
                if (line != '') {
                    line = '(' + line + ')' + fun + '(' + list[nr] + ')';
                } else {
                    line = list[nr];
                }
            }
            return line;
        }
    }
};

$(document).ready(function() {
    $(".btn").not("#tombol-delete").click(function(e) {
        e.preventDefault();

        if ($(this).data('constant') !== undefined) {
            if ($(this).data('constant') !== '=') {
                Calculator.put(Calculator[$(this).data('constant')]);
            }
        } else if ($(this).data('method') !== undefined) {
            Calculator[$(this).data('method')]();
        } else {
            if ($(this).html() !== '=') {
                Calculator.put($(this).html());
            }
        }
    });

    $("#tombol-delete").click(function(e) {
        e.preventDefault();
        Calculator.delete_last();
    });

    $(document).keydown(function(e) {
        const key = e.key;

        if (!isNaN(key)) {
            Calculator.put(key);
        } else if (key === '.') {
            Calculator.put(key);
        } else if (key === '+') {
            Calculator.put(Calculator.SUM);
        } else if (key === '-') {
            Calculator.put(Calculator.MIN);
        } else if (key === '*') {
            Calculator.put(Calculator.MULT);
        } else if (key === '/') {
            Calculator.put(Calculator.DIV);
        } else if (key === '%') {
            Calculator.put(Calculator.PROC);
        } else if (key === '(') {
            Calculator.put(Calculator.BRO);
        } else if (key === ')') {
            Calculator.put(Calculator.BRC);
        } else if (key === 'Backspace') {
            Calculator.delete_last();
        } else if (key === 'Enter') {
            Calculator.calculate();
        } else if (key === 'Escape') {
            Calculator.reset();
        }

        e.preventDefault();
    });
});
