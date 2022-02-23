import KoaRouter from 'koa-router';
import IndexController from '../controller/IndexController';
const router = new KoaRouter({ prefix: '/admin' });

router.get('/', IndexController.index);
export default router;
