// Hasta hikayesi 3D modeli: dişleri başlangıçtan plan sonuna götüren kaydırıcı.
// model.bin: tedavi planı STL'sinden üretilmiş sıkıştırılmış paket (dişler katı hareket, diş eti biçim değişimi).
import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';

const parse = (buffer) => {
    const view = new DataView(buffer);
    const headerLength = view.getUint32(4, true);
    const header = JSON.parse(new TextDecoder().decode(new Uint8Array(buffer, 8, headerLength)));
    let offset = 8 + headerLength;
    const take = (Type, count) => {
        const out = new Type(buffer, offset, count);
        offset += count * Type.BYTES_PER_ELEMENT;
        return out;
    };
    const scaled = (ints) => Float32Array.from(ints, (v) => v * header.s);

    const meshes = header.m.map((m) => {
        const position = scaled(take(Int16Array, m.v * 3));
        const morph = m.m ? scaled(take(Int16Array, m.v * 3)) : null;
        const index = take(Uint16Array, m.i);
        offset = (offset + 3) & ~3;
        return { ...m, position, morph, index };
    });
    return meshes;
};

const materials = () => ({
    tooth: new THREE.MeshPhysicalMaterial({ color: 0xfaf0dd, roughness: 0.34, clearcoat: 0.55, clearcoatRoughness: 0.35 }),
    att: new THREE.MeshPhysicalMaterial({ color: 0xfffaf2, roughness: 0.42, clearcoat: 0.3 }),
    extra: new THREE.MeshPhysicalMaterial({ color: 0xfffaf2, roughness: 0.42, clearcoat: 0.3 }),
    gum: new THREE.MeshPhysicalMaterial({ color: 0xe48f8a, roughness: 0.48, clearcoat: 0.35, clearcoatRoughness: 0.4 }),
});

export async function mountCaseViewer(root) {
    const stage = root.querySelector('[data-stage]');
    const slider = root.querySelector('[data-progress]');
    const startSide = root.dataset.start === 'b' ? 'b' : 'a'; // geometri B hâlinde saklı; a = A hâline yaklaşma miktarı

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.05;
    stage.appendChild(renderer.domElement);
    renderer.domElement.style.touchAction = 'pan-y';

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(26, 1, 1, 800);
    camera.position.set(0, 6, 175);

    scene.add(new THREE.HemisphereLight(0xffffff, 0xd6c4b0, 1.5));
    const key = new THREE.DirectionalLight(0xffffff, 1.9);
    key.position.set(30, 60, 90);
    const fill = new THREE.DirectionalLight(0xfff1e0, 0.8);
    fill.position.set(-70, 10, 40);
    scene.add(key, fill);

    // Model: x sağ-sol, y ön (kesiciler), z üst → ekranda ön yüz kameraya baksın
    const model = new THREE.Group();
    model.quaternion.setFromRotationMatrix(new THREE.Matrix4().set(-1, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1));
    scene.add(model);

    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.enablePan = false;
    controls.enableZoom = false;
    controls.rotateSpeed = 0.7;
    controls.minPolarAngle = Math.PI * 0.2;
    controls.maxPolarAngle = Math.PI * 0.8;

    const data = parse(await (await fetch(root.dataset.src)).arrayBuffer());
    const mats = materials();
    const parts = data.map((m) => {
        const geometry = new THREE.BufferGeometry();
        geometry.setAttribute('position', new THREE.BufferAttribute(m.position, 3));
        geometry.setIndex(new THREE.BufferAttribute(m.index, 1));
        if (m.morph) geometry.morphAttributes.position = [new THREE.BufferAttribute(m.morph, 3)];
        geometry.computeVertexNormals();

        const mesh = new THREE.Mesh(geometry, mats[m.k]);
        const pivot = new THREE.Vector3(...m.c);
        mesh.position.copy(pivot);
        if (m.morph) mesh.morphTargetInfluences = [0];
        model.add(mesh);
        return {
            ...m, mesh, pivot,
            target: m.t ? pivot.clone().add(new THREE.Vector3(...m.t)) : null,
            turn: m.q ? new THREE.Quaternion(...m.q) : null,
        };
    });

    const identity = new THREE.Quaternion();
    let dirty = true;
    let progress = 0;

    const apply = (p) => {
        progress = p;
        const a = startSide === 'a' ? 1 - p : p;
        parts.forEach((part) => {
            if (part.target) {
                part.mesh.position.lerpVectors(part.pivot, part.target, a);
                part.mesh.quaternion.slerpQuaternions(identity, part.turn, a);
            }
            if (part.mesh.morphTargetInfluences) part.mesh.morphTargetInfluences[0] = a;
            if (part.k === 'extra') part.mesh.visible = a < 0.5 && part.jawOn !== false;
        });
        slider.value = Math.round(p * 1000);
        slider.style.setProperty('--p', `${p * 100}%`);
        dirty = true;
    };

    const setJaw = (jaw) => {
        parts.forEach((part) => {
            part.jawOn = jaw === 'both' || part.j === jaw;
            part.mesh.visible = part.jawOn;
        });
        apply(progress);
        root.querySelectorAll('[data-jaw]').forEach((b) => b.setAttribute('aria-pressed', String(b.dataset.jaw === jaw)));
    };

    const resize = () => {
        const { clientWidth: w, clientHeight: h } = stage;
        if (!w || !h) return;
        renderer.setSize(w, h);
        camera.aspect = w / h;
        camera.position.setLength(w / h < 1.5 ? 150 : 132);   // dar ekranda kavis sığsın
        camera.updateProjectionMatrix();
        dirty = true;
    };
    new ResizeObserver(resize).observe(stage);
    resize();

    // Görünürken otomatik gidip gelir; kullanıcı dokununca durur
    const calm = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let auto = !calm;
    let visible = false;
    let clock = 0;
    const stop = () => { auto = false; };
    new IntersectionObserver(([e]) => { visible = e.isIntersecting; }, { threshold: 0.2 }).observe(root);

    slider.addEventListener('input', () => { stop(); apply(slider.value / 1000); });
    renderer.domElement.addEventListener('pointerdown', stop);
    controls.addEventListener('change', () => { dirty = true; });
    root.querySelectorAll('[data-jaw]').forEach((b) => b.addEventListener('click', () => setJaw(b.dataset.jaw)));
    root.querySelectorAll('[data-go]').forEach((b) => b.addEventListener('click', () => { stop(); apply(Number(b.dataset.go)); }));

    setJaw('both');
    root.classList.add('is-ready');

    let last = performance.now();
    const loop = (now) => {
        requestAnimationFrame(loop);
        const dt = Math.min(now - last, 60);
        last = now;
        if (!visible) return;
        if (auto) {
            clock = (clock + dt / 7000) % 1;                     // 7 sn: bekle, ilerle, bekle, dön
            const t = clock < 0.5 ? clock * 2 : 2 - clock * 2;
            const eased = THREE.MathUtils.smootherstep(t, 0.12, 0.88);
            apply(eased);
        }
        controls.update();
        if (dirty) {
            dirty = false;
            renderer.render(scene, camera);
        }
    };
    requestAnimationFrame(loop);
}
