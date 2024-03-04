//
//  BiometricType.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 27/04/23.
//

import Foundation
import LocalAuthentication
func biometricType() -> BiometricType {
        let auth = LAContext()
        let _ = auth.canEvaluatePolicy(.deviceOwnerAuthenticationWithBiometrics, error: nil)
        switch(auth.biometryType) {
        case .none:
            return .none
        case .touchID:
            return .touch
        case .faceID:
            return .face
        @unknown default:
            return .none
        }
    }
 
    enum BiometricType {
        case none
        case touch
        case face
    }
