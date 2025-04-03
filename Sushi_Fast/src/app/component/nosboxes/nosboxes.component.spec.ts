import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NosboxesComponent } from './nosboxes.component';

describe('NosboxesComponent', () => {
  let component: NosboxesComponent;
  let fixture: ComponentFixture<NosboxesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [NosboxesComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(NosboxesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
