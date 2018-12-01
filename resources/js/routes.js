import ProdutoComponent from './components/produto/Produto';
import ProdutoCadastrar from './components/produto/ProdutoCadastrar';
import EstoqueComponent from './components/estoque/EstoqueComponent';
import ProdutoView from './components/produto/ProdutoView';
import EstoqueLancamento from './components/estoque/EstoqueLancamento';
import LancamentoView from './components/estoque/LancamentoView';
import VendaComponent from './components/venda/VendaComponent';
import NovaVenda from './components/venda/NovaVenda';
import Sales from './components/venda/Sales';

const routes = [
    { path: '/housekeeping/produtos', component: ProdutoComponent, name: 'produtos'},
    { path: '/housekeeping/produtos/produto/:cdproduto', component: ProdutoView, name: 'produto'},
    { path: '/housekeeping/produtos/cadastrar', component: ProdutoCadastrar, name: 'cadastrar-produto'},
    { path: '/housekeeping/estoque', component: EstoqueComponent, name: 'estoque'},
    { path: '/housekeeping/estoque/lancamento', component: EstoqueLancamento, name: 'estoque-lancamento'},
    { path: '/housekeeping/estoque/lancamento/:id', component: LancamentoView, name: 'lancamento'},
    { path: '/housekeeping/vendas', component: VendaComponent, name: 'venda'},
    { path: '/housekeeping/vendas/nova', component: Sales, name: 'nova-venda'},
]

export default routes
