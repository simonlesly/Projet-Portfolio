import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DetailsBoxesComponent } from './details-boxes.component';

describe('DetailsBoxesComponent', () => {
  let component: DetailsBoxesComponent;
  let fixture: ComponentFixture<DetailsBoxesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [DetailsBoxesComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(DetailsBoxesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
