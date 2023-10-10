<div class="clones d-none">
    <div class="procedimentos-clone w-100 d-flex flex-wrap justify-content-between mgb-px-5">
    	<div class="w-15">
    		<input type="text" name="codigo_procedimento[]" class="form-control busca_procedimento_codigo_tratamento" autocomplete="off">
    	</div>

    	<div class="w-25">
    		<input type="text" name="nome_procedimento[]" class="form-control busca_procedimento_tratamento" autocomplete="off">
    		<input type="hidden" class="autocomplete_procedimento_id" name="procedimento_id[]">
    	</div>

    	<div class="w-15">
    		<input type="text" name="sessoes_procedimento[]" class="form-control number" autocomplete="off">
    	</div>

    	<div class="w-10">
    		<div class="div-money">
    	    	<label for="valor_procedimento" class="moeda"><span>R$</span></label>
    	    	<input type="text" name="valor_procedimento[]" class="form-control money" autocomplete="off">
    	    </div>
    	</div>

    	<div class="w-10">
    		<div class="div-money-opc">
    	    	<label for="valor_desconto" class="moeda"><i class="ph ph-caret-down"></i><span>R$</span></label>
    	    	<input type="text" name="desconto_procedimento[]" class="form-control money" id="valor_desconto" autocomplete="off">
    	    	<input type="hidden" name="tipo_desconto[]" class="form-control" receber-tipo-desconto="true" value="real">
    	    </div>
    	</div>

    	<div class="w-10 text-center">
            <div class="div-money">
                <label for="valor_procedimento" class="moeda"><span>R$</span></label>
                <input type="text" name="total_procedimento[]" class="form-control money" readonly readonly-disabled autocomplete="off">
            </div>
    	</div>

    	<div class="w-10 d-flex align-items-center justify-content-center">
    		<i
    			data-bs-toggle="tooltip"
                data-bs-placement="bottom"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="Remover"
    			class="ph ph-x icone-nome minimo pointer remover_procedimento_tratamento"
    		></i>
    	</div>
    </div>
</div>