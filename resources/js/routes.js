import ProdutoComponent from './components/produto/Produto';
import ProdutoCadastrar from './components/produto/ProdutoCadastrar';
import EstoqueComponent from './components/estoque/EstoqueComponent';
import ProdutoView from './components/produto/ProdutoView';
import EstoqueLancamento from './components/estoque/EstoqueLancamento';
import LancamentoView from './components/estoque/LancamentoView';

const routes = [
    { path: '/housekeeping/produtos', component: ProdutoComponent, name: 'produtos'},
    { path: '/housekeeping/produtos/produto/:cdproduto', component: ProdutoView, name: 'produto'},
    { path: '/housekeeping/produtos/cadastrar', component: ProdutoCadastrar, name: 'cadastrar-produto'},
    { path: '/housekeeping/estoque', component: EstoqueComponent, name: 'estoque'},
    { path: '/housekeeping/estoque/lancamento', component: EstoqueLancamento, name: 'estoque-lancamento'},
    { path: '/housekeeping/estoque/lancamento/:id', component: LancamentoView, name: 'lancamento'},
]

export default routes
