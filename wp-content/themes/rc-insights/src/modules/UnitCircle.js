class UnitCircle {

    constructor() {
        if (document.querySelector(".d3-canvas")){
            // Constants
            this.WIDTH = Math.min(window.innerWidth, 350);
            this.HEIGHT = Math.min(350, this.WIDTH);
            this.MARGIN_X = 20;
            this.MARGIN_Y = 20;
            this.ORIGIN_X = this.HEIGHT / 2;
            this.ORIGIN_Y = this.WIDTH / 2;
            this.Gen = d3.line();
            this.svg = d3.select('.d3-canvas')
                .append('svg')
                    .attr('width', this.WIDTH)
                    .attr('height', this.HEIGHT)
                    .attr('class', "d3");
            this.radiusElement = document.getElementById('myRadius')

            // Set initial configuration
            this.currentX = this.scale(Math.sqrt(2) / 2, this.MARGIN_X, this.WIDTH - this.MARGIN_X, -1.5, 1.5);
            this.currentY = this.scale(Math.sqrt(2) / 2, this.MARGIN_Y, this.HEIGHT - this.MARGIN_Y, 1.5, -1.5);
            this.radius = this.scale(1, -1.5, 1.5, 0, this.WIDTH / 2 - this.MARGIN_X)
            this.startAngle = (Math.PI * 0 / 180) - Math.PI * 2
            this.endAngle = Math.atan(this.currentY / this.currentX) - Math.PI * 2
            this.events();
            this.setup();
        }

    }
    // 2. events
    events() {
        // Event Handlers

        this.currentAngle = this.radiusElement.value
        this.radiusElement.addEventListener("input", () => {
            this.update(this.radiusElement.value);
        });

    }
    update(currentAngle){

        // Create a new arc path
        const arc = d3.arc()
            .innerRadius(15)
            .outerRadius(this.radius)
            .startAngle(0)
            .endAngle(Math.PI * currentAngle / 180)

        // Bind the arc path
        d3.select('.arc-path')
            .datum(arc)
            .attr('d', (d) => { return d })
            .attr('transform', `translate(${this.ORIGIN_X},${this.ORIGIN_Y})`)
            .attr('transform', `translate(${this.ORIGIN_X},${this.ORIGIN_Y}) rotate(${90}) scale(-1,1)`)

        // Update Theta
        d3.select('.theta')
            .text(`\u03B8 = ${parseInt(currentAngle)} \u00B0`)


        // Update Trig Functions
        const x = this.radius * Math.sin(Math.PI * currentAngle / 180);
        const y = this.radius * - Math.cos(Math.PI * currentAngle / 180);

        let cosecant;
        let secant;

        // Fix infinite errors
        if (currentAngle == 0){
            secant = 99999;
        }else if (currentAngle == 180){
            secant = -99999;
        }
        else{
            // Because we are mirroring the circle, we need to swap secant and cosecant
            secant = (1 / (Math.sin(Math.PI * currentAngle / 180))) * this.radius     // <-- This is the CSC formula
        }


        if (currentAngle == 90) {
            cosecant = 99999;
        }else if (currentAngle == 270){
            cosecant = -99999;
        } else{
            // Because we are mirroring the circle, we need to swap secant and cosecant
            cosecant = (1 / (Math.cos(Math.PI * currentAngle / 180))) * this.radius   // <-- this is the SEC formula
        }


        if (secant == 'Infinity')
            secant = 99999


        const sine = [
            [x, 0],
            [x, y]
        ];
        const cosine = [
            [x, y],
            [0, y]
        ];
        const hypotenuse = [
            [0, 0],
            [x, y]
        ];
        const cotangent = [
            [x, y],
            [0, -cosecant]
        ]
        const tangent = [
            [x, y],
            [secant, 0]
        ]

        const sinLine = this.Gen(sine);
        const cosineLine = this.Gen(cosine);
        const tangentLine = this.Gen(tangent);
        const cotangentLine = this.Gen(cotangent);
        const hypotenuseLine = this.Gen(hypotenuse);


        d3.select('.sine')
            .attr('d', sinLine);
        d3.select('.cosine')
            .attr('d', cosineLine);
        d3.select('.hypotenuse')
            .attr('d', hypotenuseLine)
        d3.select('.cotangent')
            .attr('d', cotangentLine)
        d3.select('.tangent')
            .attr('d', tangentLine)
    }
    // D3 setup function
    setup = () => {
        this.buildAxes();
        this.buildInitial();
    }

    buildAxes() {
        // Set Scales
        const xPosScale = d3.scaleLinear()
            .domain([-1.5, 1.5])
            .range([this.WIDTH / 2, this.WIDTH - this.MARGIN_X])
        const xNegScale = d3.scaleLinear()
            .domain([1.5, -1.5])
            .range([this.MARGIN_X, this.WIDTH / 2])
        const yPosScale = d3.scaleLinear()
            .domain([-1.5, 1.5])
            .range([this.HEIGHT / 2, this.MARGIN_Y])
        const yNegScale = d3.scaleLinear()
            .domain([-1.5, 1.5])
            .range([this.HEIGHT / 2, this.HEIGHT - this.MARGIN_Y])

        // Configure Axes
        // Here we need a positive and negative for each axis
        const xPosAxis = d3.axisBottom(xPosScale)
            .tickValues([1])
            .tickFormat((d, i) => ['2\u03c0'][i]);
        const xNegAxis = d3.axisBottom(xNegScale)
            .tickValues([1])
            .tickFormat((d, i) => ['\u03c0'][i]);
        const yPosAxis = d3.axisLeft(yPosScale)
            .tickValues([1])
            .tickFormat((d, i) => ['\u03c0 / 2'])
        const yNegAxis = d3.axisLeft(yNegScale)
            .tickValues([1])
            .tickFormat((d, i) => ['3\u03c0 / 2'][i]);




        // append axes
        this.svg.append("g")
            .attr('class', 'x-positive-axis')
            // align the axis to the middle of the canvas
            .attr("transform", `translate(0,${this.HEIGHT / 2})`)
            .call(xPosAxis);
        this.svg.append("g")
            .attr('class', 'x-negative-axis')
            // align the axis to the middle of the canvas
            .attr("transform", `translate(0,${this.HEIGHT / 2})`)
            .call(xNegAxis);
        this.svg.append("g")
            .attr('class', 'y-positive-axis')
            // align the axis to the middle of the canvas
            .attr("transform", `translate(${this.WIDTH / 2},0)`)
            .call(yPosAxis);
        this.svg.append("g")
            .attr('class', 'y-negative-axis')
            // align the axis to the middle of the canvas
            .attr("transform", `translate(${this.WIDTH / 2},0)`)
            .call(yNegAxis);

        // Generate a complete circle
        const arc = d3.arc()
            .innerRadius(0)
            .outerRadius(this.radius)
            .startAngle(this.startAngle)
            .endAngle(Math.PI * 2)

        // Append complete circle
        this.svg.append('path')
            .datum(arc)
            .attr('d', (d) => { return d })
            .attr('transform', `translate(${this.ORIGIN_X},${this.ORIGIN_Y}) rotate(90)`)
            .attr('fill', 'none')
            .attr('class', 'full-path')
            .attr('stroke', 'white')
            .attr('opacity', .3)
    }
    buildInitial() {

        // Create the Ray
        // Making a line Generator
        var x = this.radius * Math.sin(Math.PI * this.currentAngle / 180);
        var y = this.radius * - Math.cos(Math.PI * this.currentAngle / 180);
        const tanXIntercept = this.radius * Math.tan(Math.PI * this.currentAngle / 180)

        // Because we are mirroring the circle, we need to swap secant and cosecant
        const secant = (1 / (Math.cos(Math.PI * this.currentAngle / 180))) * this.radius
        const cosecant = (1 / (Math.sin(Math.PI * this.currentAngle / 180))) * this.radius




        const tangent = [
            [0, -cosecant],
            [x, y],
        ]
        const cotangent = [
            [x, y],
            [secant, 0]
        ]
        const hypotenuse = [
            [0, 0],
            [x, y]
        ];
        const sine = [
            [x, y],
            [x, 0]
        ];
        const cosine = [
            [x, y],
            [0, y]
        ];


        const sinLine = this.Gen(sine);
        const cosineLine = this.Gen(cosine);
        const tangentLine = this.Gen(tangent);
        const cotangentLine = this.Gen(cotangent);
        const hypotenuseLine = this.Gen(hypotenuse);

        // Because of having to mirror the direction of the arc, we need to
        // swap sine and cosine
        this.svg.append('path')
            .attr('d', cosineLine) // <-- USE COS because of mirroring
            .attr('class', 'sine')
            .attr('transform', `translate(${this.ORIGIN_X},${this.ORIGIN_Y}) rotate(90) scale(-1,1)`)
        this.svg.append('path')
            .attr('d', sinLine)  // <-- USE SIN because of mirroring
            .attr('class', 'cosine')
            .attr('transform', `translate(${this.ORIGIN_X},${this.ORIGIN_Y}) rotate(90) scale(-1,1)`)
        this.svg.append('path')
            .attr('d', hypotenuseLine)
            .attr('class', 'hypotenuse')
            .attr('transform', `translate(${this.ORIGIN_X},${this.ORIGIN_Y}) rotate(90) scale(-1,1)`)
        this.svg.append('path')
            .attr('d', tangentLine)
            .attr('class', 'cotangent')
            .attr('transform', `translate(${this.ORIGIN_X},${this.ORIGIN_Y}) rotate(90) scale(-1,1)`)
        this.svg.append('path')
            .attr('d', cotangentLine)
            .attr('class', 'tangent')
            .attr('transform', `translate(${this.ORIGIN_X},${this.ORIGIN_Y}) rotate(90) scale(-1,1)`)

        // This is the full circle
        const fullArc = d3.arc()
            .innerRadius(15)
            .outerRadius(this.radius)
            .startAngle(0)
            .endAngle(Math.PI * this.currentAngle / 180)

        this.svg.append('path')
            .datum(fullArc)
            .attr('d', (d) => { return d })
            .attr('transform', `translate(${this.ORIGIN_X},${this.ORIGIN_Y})`)
            .attr('transform', `translate(${this.ORIGIN_X},${this.ORIGIN_Y}) rotate(${90}) scale(-1,1)`)
            .attr('class', 'arc-path')



        //Drag point
        // svg.append('circle')
        //     .attr('cx', () => radius * Math.cos(endAngle))
        //     .attr('cy', () => radius * Math.sin(endAngle))
        //     .attr('r', '6px')
        //     .attr('class', 'ray-point')
        //     .attr('transform', `translate(${originX},${originY})`)
        //     .call(dragCircle)

        // Theta
        this.svg.append("text")
            .text("\u03B8 = 45\u00B0")
            .attr('fill', 'aqua')
            .attr('class', 'theta')
            .attr('x', 20)
            .attr('y', 20)

        // Coordinates
        // this.svg.append("text")
        //     .text("\u87302")
        //     .attr('fill', 'aqua')
        //     .attr('class', 'theta')
        //     .attr('x', this.WIDTH - 70)
        //     .attr('y', 20)
    }

// Utility Functions
    scale(number, inMin, inMax, outMin, outMax) {
        return (number - inMin) * (outMax - outMin) / (inMax - inMin) + outMin;
    }
}

export default UnitCircle;