$(document).ready(function(){    
    $(document).on('change', '.select-client', view_client) // Visualizar dados do cliente ao selecionar na venda
    $(document).on('click', '.button-add-product', add_product) // adicionar produto
    $(document).on('click', '.button-remove-product', remove_product) // remover produto
    $(document).on('click', '.button-add-installment', add_installment) // adicionar produto
    $(document).on('click', '.button-remove-installment', remove_installment) // remover produto
    $(document).on('input', '.calc-subtotal', calc_subtotal) // calcular subtotal dos pedidos
    $(document).on('input', '.value', active_button_sale) // ativar btn vendas
    $(document).on('input', '.invoice_date', active_button_sale) // ativar btn vendas
    // $(document).on('submit', '.form-send-sale', send_sale) // ativar btn vendas

    $('form').submit(function(event) {
        event.preventDefault();
    
        var produtos = [];
        $('#productList > div').each(function() {
            var idProduto = $(this).find('input[name="id_product[]"]').val();
            var nomeProduto = $(this).find('input[name="produto[]"]').val();
            var quantidade = $(this).find('input[name="quantity[]"]').val();
            var precoUnitario = $(this).find('input[name="price[]"]').val();
    
            produtos.push({
                id_product: idProduto,
                produto: nomeProduto,
                quantity: quantidade,
                price: precoUnitario,
            });
        });

        var installments = [];
        $('#installmentList').each(function() {
            var invoice_date = $(this).find('input[name="invoice_date[]"]').val();
            var value = $(this).find('input[name="value[]"]').val();
    
            installments.push({
                invoice_date: invoice_date,
                value: value,
            });
        });
    
        // adiciona os dados dos produtos como um campo 'produtos' no formulário
        $('<input>').attr({
            type: 'hidden',
            name: 'produtos',
            value: JSON.stringify(produtos)
        }).appendTo('form');
    
        // adiciona os dados dos produtos como um campo 'installments' no formulário
        $('<input>').attr({
            type: 'hidden',
            name: 'installments',
            value: JSON.stringify(installments)
        }).appendTo('form');
    
        this.submit();
    });

    

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

    
    var i = 0;
    var code = 0;
    function add_product(){
        var idProduct = $('#id_product').val();
        var productName = $('#id_product option:selected').text();

        $.ajax({
            url: '/product/' + idProduct,
            type: 'GET',
            success: function(response){
                i++;
                code++;
                

                $('#productList').append(`
                    <div id="product-${i}" class="grid grid-cols-5 md:gap-6">
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
                            <div data-product="${i}" class="button-remove-product border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" style="background: red; margin-top: 35px; cursor: pointer; color: #fff; text-align: center">Remover</div>            
                        </div>
                    </div>
                `);

                calc_installment()
                calc_total()
                active_button_sale()
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
        active_button_sale()

    }

    function calc_subtotal(){
        code = $(this).data('code')
        quantity = $(`.quantity-${code}`).val()
        price = $(`.price-${code}`).val()
        subtotal = price * quantity;

        $(`.subtotal-${code}`).val(subtotal)
        calc_total()
    }

    function calc_total(){
        total = 0;

        $('input[name="subtotal[]"]').each(function() {
            console.log($(this).val());

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

    codeInstallment = 0;
    function add_installment(){
        codeInstallment++;

        $('#installmentList').append(`
            <div class="installment-${codeInstallment} relative z-0 w-full group ml-3 mt-4">
                <label class="block font-medium text-sm text-gray-700">Valor</label>
                <input required id="value" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="number" name="value[]" />
            </div>

            <div class="installment-${codeInstallment} relative z-0 w-full group ml-3 mt-4">
                <label class="block font-medium text-sm text-gray-700">Data de Vencimento</label>
                <input required type="date" id="invoice_date" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" name="invoice_date[]" />
            </div>
            <div class="installment-${codeInstallment} relative z-0 w-full group ml-3 mt-4">
                <div required data-installment="${codeInstallment}" class="button-remove-installment border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" style="background: red; margin-top: 35px; cursor: pointer; color: #fff; text-align: center">Remover</div>            
            </div>
        `);

        calc_installment()
        active_button_sale()
    }

    function calc_installment(){
        quantituInstallment = $('input[name="value[]"]').length
        valor = calc_total() / quantituInstallment;
        $('input[name="value[]"]').val(valor);
    }

    function calc_installment_client(){
        console.log($(this).data());
    }

    function remove_installment(){
        codeInstallment = $(this).data('installment');
        $(`.installment-${codeInstallment}`).remove()
        calc_installment()
        active_button_sale()
        
    }

    function active_button_sale(){
        var invoice_date = $('input[name="invoice_date[]"]').val();
        console.log(invoice_date);
        
        $('input[name="value[]"]').each(function(index, element) {
            var value = $(this).val();
            $('.button-send-sale').prop('disabled', false);
        });
    }

  });

