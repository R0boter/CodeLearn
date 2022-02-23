import Koa from 'koa';
import router from './router';

const app = new Koa();

app.use(router.routes()).use(router.allowedMethods());

app.listen(8000, () => {
  console.log('http://localhost:8000');
});
