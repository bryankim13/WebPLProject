import * as internal from "stream";

export class Camera {
    constructor(
        public brand: string,
        public model: string,
        public lens: string,
        public megaPix: number,
    ){}
}
