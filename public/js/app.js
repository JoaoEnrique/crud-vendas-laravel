$(document).ready(function(){    
    $(document).on('change', '.select-client', view_client) // Visualizar dados do cliente ao selecionar na venda
    $(document).on('click', '.button-add-product', add_product) // adicionar produto
    $(document).on('click', '.button-remove-product', remove_product) // remover produto
    $(document).on('click', '.button-add-installment', add_installment) // adicionar produto
    $(document).on('click', '.button-remove-installment', remove_installment) // remover produto
    $(document).on('input', '.calc-subtotal', calc_subtotal) // calcular subtotal dos pedidos
    // $(document).on('submit', '.form-send-sale', send_sale) // ativar btn vendas

    errorrProduct = 0
    errorInstallment = 0
    $('.form-send-sale').submit(function(event) {
        event.preventDefault();
        $('#errors').empty();
    
        var products = extractProducts();
        var installments = extractInstallments();
        var errors = validateForm(products, installments);

        if (errors.length > 0) {
            displayErrors(errors);
            return false; // Impede o envio do formulário se a validação falhar
        }

        // adiciona os dados dos produtos como um campo 'produtos' no formulário
        $('<input>').attr({
            type: 'hidden',
            name: 'produtos',
            value: JSON.stringify(products)
        }).appendTo('form');
    
        // adiciona os dados dos produtos como um campo 'installments' no formulário
        $('<input>').attr({
            type: 'hidden',
            name: 'installments',
            value: JSON.stringify(installments)
        }).appendTo('form');
    
        this.submit();
    });

    function extractProducts() {
        var products = [];
    
        $('#productList > div').each(function() {
            var idProduto = $(this).find('input[name="id_product[]"]').val();
            var nomeProduto = $(this).find('input[name="produto[]"]').val();
            var quantidade = $(this).find('input[name="quantity[]"]').val();
            var precoUnitario = $(this).find('input[name="price[]"]').val();
            var subtotal = $(this).find('input[name="subtotal[]"]').val();
    
            products.push({
                id_product: idProduto,
                produto: nomeProduto,
                quantity: quantidade,
                price: precoUnitario,
                subtotal: subtotal,
            });
        });
    
        return products;
    }
    
    function extractInstallments() {
        var installments = [];
    
        $('#installmentList > div').each(function() {
            var invoice_date = $(this).find('input[name="invoice_date[]"]').val();
            var value = $(this).find('input[name="value[]"]').val();
    
            installments.push({
                invoice_date: invoice_date,
                value: value,
            });
        });
    
        return installments;
    }

    function validateForm(products, installments) {
        var errors = [];
    
        if (products.length === 0) {
            errors.push('Adicione pelo menos um produto.');
        }

        products.forEach(product => {
            if(!product.produto || !product.quantity || !product.price)
                errors.push('Preencha todos os campos do produto');
        })

        installments.forEach(installment => {
            if(!installment.invoice_date || !installment.value)
                errors.push('Preencha todos os campos da parcela');
        })
    
        if (installments.length === 0) {
            errors.push('Adicione pelo menos uma parcela.');
        }
    
        var totalPrice = calc_total_price(products);
        var totalValue = calc_total_value(installments);

        console.log(totalPrice);
        console.log(totalValue);

        if (totalPrice > totalValue) {
            errors.push('O preço dos produtos ultrapassa o valor das parcelas.');
        } else if (totalPrice < totalValue) {
            errors.push('O valor das parcelas ultrapassa o preço dos produtos.');
        }
    
        return errors;
    }

    function displayErrors(errors) {
        var $errorsContainer = $('#errors');
    
        errors.forEach(function(error) {
            $errorsContainer.append(`
                <div class="error bg-red-100 border mb-4 border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Erro no cadastro!</strong>
                    <span class="block sm:inline text-error">${error}</span>
                </div>
            `);
        });
    }
    
    function calc_total_price(products) {
        var totalPrice = 0;
        products.forEach(function(product) {
            totalPrice += parseFloat(product.subtotal);
        });
        return totalPrice;
    }
    
    function calc_total_value(installments) {
        var totalValue = 0;
        installments.forEach(function(installment) {
            totalValue += parseFloat(installment.value);
        });
        return totalValue;
    }

    data_tables() //datatables dos clientes prodtutos e vendas

    // Visualizar dados do cliente ao selecionar na venda
    function view_client(){
        var idClient = $(this).val();

        $.ajax({
            url: '/client/' + idClient,
            type: 'GET',
            success: function(response){
                $('#clientData').html(`
                    <p>Nome:  ${response.name}</p>
                    <p>Email: ${response.email} </p>
                    <p>CPF / CNPJ: ${response['cpf/cnpj']}</p>
                    <p>RG: ${response.rg}</p>
                    <p>Cidade: ${response.city}</p>
                    <p>Telefone: ${response.phone}</p>
                `);
            },
            error: function(error){
                console.log(error.responseText);
            }
        });
    }
    
    function add_product(){
        var idProduct = $('#id_product').val();
        var productName = $('#id_product option:selected').text();
        code = 0;

        $('#productList > div').each(function() {
            code = $(this).data('code');
        });

        $.ajax({
            url: '/product/' + idProduct,
            type: 'GET',
            success: function(response){
                code++;

                $('#productList').append(`
                    <div data-code='${code}' id="product-${code}" class="grid grid-cols-5 md:gap-6">
                        <div class="relative z-0 w-full group ml-3 mt-4">
                            <label class="block font-medium text-sm text-gray-700" for="produto">Produto</label>
                            <input class="hidden" type="text" name="id_product[]" value="${idProduct}" />
                            <input min="1" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="text" name="produto[]" value="${productName}" />
                        </div>
                        <div class="relative z-0 w-full group ml-3 mt-4">
                            <label class="block font-medium text-sm text-gray-700" for="quantity">Quantidade</label>
                            <input min="1" data-code="${code}" required class="quantity-${code} calc-subtotal border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="number" name="quantity[]" value='1' />
                        </div>
                        <div class="relative z-0 w-full group ml-3 mt-4">
                            <label class="block font-medium text-sm text-gray-700" for="price">Preço Unitário</label>
                            <input min="1" data-code="${code}" required class="price-${code} calc-subtotal border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="number" name="price[]" value="${response.price}" />
                        </div>
                        <div class="relative z-0 w-full group ml-3 mt-4">
                            <label class="block font-medium text-sm text-gray-700" for="subtotal">Subtotal</label>
                            <input disabled min="1" onlyread required class="subtotal-${code} border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="number" name="subtotal[]" value='${response.price}'/>
                        </div>
                        <div class="relative z-0 w-full group ml-3 mt-4">
                            <div data-product="${code}" class="text-center cursor-pointer bg-red-600 button-remove-product rounded-md shadow-sm mt-6 flex justify-center align-super text-white" style="height: 40px; align-items: center;">Remover</div>            
                        </div>
                    </div>
                `);

                calc_installment()
                calc_total()
            },
            error: function(error){
                console.log(error.responseText);
            }
        });
    }

    function remove_product(){
        product = $(`#product-${$(this).data('product')}`)
        product.remove()

        calc_installment()
    }

    function calc_subtotal(){
        code = $(this).data('code')
        quantity = $(`.quantity-${code}`).val()
        price = $(`.price-${code}`).val()
        subtotal = price * quantity;

        $(`.subtotal-${code}`).val(subtotal)
        calc_installment()
        calc_total()
    }

    function calc_total(){
        total = 0;

        $('input[name="subtotal[]"]').each(function() {
            var value = $(this).val();
            total += parseFloat(value);
        });

        $('.total').html("Total: R$ " + total)
        $('.input-total').val(total)
        return total;
    }

    function data_tables(){
        $('#datatables').DataTable();
    }

    function add_installment(){
        codeInstallment = 0;

        $('#installmentList > div').each(function() {
            codeInstallment = $(this).data('codeInstallment');
        });

        $('#installmentList').append(`
            <div data-code='${codeInstallment}' id="installment-${codeInstallment}"  class="grid grid-cols-3 md:gap-6">
                <div class="installment-${codeInstallment} relative z-0 w-full group ml-3 mt-4">
                    <label class="block font-medium text-sm text-gray-700">Valor</label>
                    <input required id="value" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="number" name="value[]" />
                </div>

                <div class="installment-${codeInstallment} relative z-0 w-full group ml-3 mt-4">
                    <label class="block font-medium text-sm text-gray-700">Data de Vencimento</label>
                    <input required type="date" id="invoice_date" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" name="invoice_date[]" />
                </div>
                <div class="installment-${codeInstallment} relative z-0 w-full group ml-3 mt-4">
                    <div required data-installment="${codeInstallment}" class="text-center cursor-pointer bg-red-600 button-remove-installment rounded-md shadow-sm mt-6 flex justify-center align-super text-white" style="height: 40px; align-items: center;">Remover</div>            
                </div>
            </div>
        `);

        calc_installment()
    }

    function calc_installment(){
        quantituInstallment = $('input[name="value[]"]').length
        valor = calc_total() / quantituInstallment;
        $('input[name="value[]"]').val(valor);
    }

    function remove_installment(){
        installment = $(`#installment-${$(this).data('installment')}`)
        installment.remove()

        calc_installment()
    }

  });

