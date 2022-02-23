import { Context } from 'koa';

class IndexController {
  async index(ctx: Context) {
    ctx.body = [0, 2, 7, 4, 2];
  }
}

export default new IndexController();
